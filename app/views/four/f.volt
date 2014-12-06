{{ content() }}

<h1>Delete Flight Record</h1>




<h3>
	Flights: {{ flights|length }}
</h3>
<table class="table table-striped table-hover table-bordered table-condensed">
	{% for f in flights %}
		{% if loop.first %}
			<thead>
				<tr>
					{% for name,value in f %}
						<th>{{ name }}</th>
					{% endfor %}
					<th>Delete</th>
				</tr>
			</thead>
		{% endif %}
		<tbody>
			<tr>
				{% for name,value in f %}
					<td class="value">{{ value }}</td>
				{% endfor %}
				<td>
					<div>
						<a href="/four/delete/{{f['flight_number']}}/" class="delete btn btn-primary">X</a>
						<span class="assignMessage"></span>
					</div>
				</td>
			</tr>
		</tbody>

	
	{% endfor %}
</table>

<script>

	function pad(n, width, z) {
		z = z || '0';
		n = n + '';
		return n.length >= width ? n : new Array(width - n.length + 1).join(z) + n;
	}

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

				if( $($inputs.get(i)).hasClass('time') ){
					value = pad(value, 4);
					$($inputs.get(i)).val(value.substr(0,2))
					i++;
					$($inputs.get(i)).val(value.substr(2,2))
				} else {
					$($inputs.get(i)).val(value);
				}

				i++;
			});


			$('#modifyForm').show();

		});

		$('.delete').click(function(e) {
			e.preventDefault();
			var $this = $(this);
			var $row = $this.closest('tr');
			var url = $this.attr('href');

			$.ajax({
				type		: "GET",
				url			: url,
				success		: function(response) {
					$row.html('<td colspan="12" style="background-color:#F2DEDE;text-align:center;"><strong>'+response+'</strong></td>');
				}
			});

		});

	});
</script>