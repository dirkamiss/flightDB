{{ content() }}

<h1>Modify Crew Member Record</h1>



<form id="modifyForm" method="post" class="form-horizontal hide" action="">

	<div class="form-group">
		<div class="span6">
			<label>ID</label>
			<input name="id" type="number" readonly>
			<label>Full Name</label>
			<input name="name" type="text">
			<label>Salary</label>
			<input name="salary" type="number" min="0" step="10000">
			<label>Position</label>
			<select name="position">
				<option value="Pilot">Pilot</option>
				<option value="Co-pilot">Co-Pilot</option>
			</select>
		</div>
		
		<label>Seniority</label>
		<input name="seniority" type="number" min="0">
		<label>Flying Hours</label>
		<input name="hours" type="number" min="0">
		<label>Supervisor</label>
		<input name="supervisor" type="number" min="0">
		<label>Aircrafts Certified to Fly (comma separated)</label>
		<input id="certified" name="certified" type="text">

	</div>
	<br><br>
	<a href="#" class="submit btn btn-primary">Submit</a>
</form>




<h3>
	Crew Members: {{ crew|length }}
</h3>
	
<table class="table table-striped table-hover table-bordered table-condensed">
	{% for c in crew %}
		{% if loop.first %}
			<thead>
				<tr>
					{% for name,value in c %}
						<th>{{ name }}</th>
					{% endfor %}
					<th>Modify</th>
				</tr>
			</thead>
		{% endif %}
		<tbody>
			<tr>
				{% for name,value in c %}
					<td class="value">
						{{ value }}
					</td>
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
			var $inputs = $('#modifyForm').find('input, select');

			var i = 0;
			$data.each( function() {
				var value = $.trim($(this).text());
				$($inputs.get(i)).val(value);
				i++;
			});

			var noBrace = $('#certified').val().replace(/[{}]/g, "");
			$('#certified').val(noBrace);

			$('#modifyForm').show();

		});

	});
</script>