{{ content() }}

<h1>Insert or Modify Maintenance Record</h1>
<p>(To modify a record use its existing log_number)</p>



<form id="modifyForm" method="post" class="form-horizontal" action="">

	<div class="form-group">
		<div class="span6">
			<label>Log Number</label>
			<input name="logNumber" type="text">
			<label>Aircraft</label>
			<input name="aircraft" type="text">
			<label>Date</label>
			<input name="date" type="date">
		</div>

		<label>Jobs (comma separated)</label>
		<input id="job" name="job" type="text">
		<label>Next Scheduled Maintenance</label>
		<input name="next" type="date">

	</div>
	<br><br>
	<a href="#" class="submit btn btn-primary">Submit</a>
</form>




<h3>
	Maintenance Records: {{ records|length }}
</h3>
<table class="table table-striped table-hover table-bordered table-condensed">
	{% for r in records %}
		{% if loop.first %}
			<thead>
				<tr>
					{% for name,value in r %}
						<th>{{ name }}</th>
					{% endfor %}
					<th>Modify</th>
				</tr>
			</thead>
		{% endif %}
		<tbody>
			<tr>
				{% for name,value in r %}
					<td class="value">{{ value }}</td>
				{% endfor %}
				<td>
					<div>
						<a href="#" class="modify btn">Modify</a>
						<span class="assignMessage"></span>
					</div>
				</td>
			</tr>
		</tbody>

	
	{% endfor %}
</table>

<script>

	$(document).ready(function() {

		$('.submit').click(function(e) {
			var $form = $(this).closest('form');
			$form.submit();


			e.preventDefault();
		});

		$('.assign').click(function(e) {
			e.preventDefault();
			var $this = $(this);
			var $input = $this.siblings('input');
			var $span = $this.siblings('span');
			var url = $this.attr('href') + $input.val();

			$.ajax({
				type		: "GET",
				url			: url,
				beforeSend	: function() {
					$('.assignMessage').html('');
				},
				complete	: function() {
					$input.val('');
				},
				success		: function(response) {
					$span.html('Saved');
				}
			});
		});

		$('.modify').click(function(e) {
			e.preventDefault();

			var $this = $(this);
			var $row = $this.closest('tr');
			var $data = $row.find('td.value');
			var $inputs = $('#modifyForm').find('input');

			var i = 0;
			$data.each( function() {
				var value = $.trim($(this).text());
				$($inputs.get(i)).val(value);
				i++;
			});

			var noBrace = $('#job').val().replace(/[{}]/g, "");
			$('#job').val(noBrace);

			$('#modifyForm').show();

		});

	});
</script>