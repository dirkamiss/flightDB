{{ content() }}

<h1>Modify Flight Record</h1>



<form id="modifyForm" method="post" class="form-horizontal hide" action="">

	<div class="form-group">
		<div class="span6">
			<label>Flight Number</label>
			<input name="flightNumber" type="number" readonly>
			<label>Aircraft Used</label>
			<input name="aircraft" type="text">
			<label>Departure City</label>
			<input name="departCity" type="text">
			<label>Destination City</label>
			<input name="destCity" type="text">
		</div>
		
		<label>Departure Hour</label>
		<input class="time" type="number" name="departHour" value="0" min="0" max="23">
		<label>Departure Minutes</label>
		<input class="time" type="number" name="departMin" value="0" min="0" max="59">
		<label>Arrival Hour</label>
		<input class="time" type="number" name="arriveHour" value="23" min="0" max="23">
		<label>Arrival Minutes</label>
		<input class="time" type="number" name="arriveMin" value="59" min="0" max="59">

		<div class="span6">
			<label>Airfare</label>
			<input name="airfare" type="number" value="0" min="0" step="50">
			<label>Mileage</label>
			<input name="mileage" type="number" value="0" min="0" step="50">
			<label>Number of Booked Passengers</label>
			<input name="bookedPassengers" type="number" value="0" min="0">
		</div>

		<label>Pilot ID</label>
		<input name="pilotId" type="number" min="0">
		<label>Co-Pilot ID</label>
		<input name="coPilotId" type="number" min="0">

	</div>
	<br><br>
	<a href="#" class="submit btn btn-primary">Submit</a>
</form>




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
					<th>Modify</th>
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
						<a href="#" class="modify btn">Modify</a>
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

	});
</script>