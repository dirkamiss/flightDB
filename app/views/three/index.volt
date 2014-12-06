<h1>Special Routes</h1>

<div class="row text-center">
	<form id="cities">
		<label>Departure city</label>
		<select name="depart_city">
			<option value=""></option>
			{% for dept in depart_cities %}
				{% for name,value in dept %}
					<option value="{{ value|e }}">{{ value|e }}</option>
				{% endfor %}	
			{% endfor %}
		</select>
		<label>Destination city</label>
		<select name="dest_city">
			<option value=""></option>
			{% for dest in dest_cities %}
				{% for name,value in dest %}
					<option value="{{ value|e }}">{{ value|e }}</option>
				{% endfor %}
			{% endfor %}
		</select>
	</form>
</div>

<div class="row">

	<div class="span3">
		<h3>Option A</h3>
		<form id="option-A" action="/query/threea">
			
			<label>Maximum Stops</label>
			<input type="number" name="stops" value="3" min="0" max="3">
			<label>Maximum Mileage</label>
			<input type="number" name="miles" value="1500" min="0" step="50">
			<br>
			<a href="#" class="submit btn btn-primary">Submit</a>
		</form>
	</div>

	<div class="span3">
		<h3>Option B</h3>
		<form id="option-B" action="/query/threeb">
			
			<label>Maximum Airfare</label>
			<input type="number" name="airfare" value="500" min="0" max="9999" step="10">
			<br>
			<a href="#" class="submit btn btn-primary">Submit</a>
		</form>
	</div>

	<div class="span3">
		<h3>Option C</h3>
		<form id="option-C" action="/query/threec">
			<label>Earliest Departure Hour</label>
			<input type="number" name="early_hour" value="0" min="0" max="23">
			<label>Earliest Departure Minutes</label>
			<input type="number" name="early_min" value="0" min="0" max="59">
			<label>Latest Arrival Hour</label>
			<input type="number" name="late_hour" value="23" min="0" max="23">
			<label>Latest Arrival Minutes</label>
			<input type="number" name="late_min" value="59" min="0" max="59">
			<br>
			<a href="#" class="submit btn btn-primary">Submit</a>
		</form>
	</div>

	<div class="span3">
		<h3>Option D</h3>
		<form id="option-D" action="/query/threed">
			
			<label>Find Passengers travelling via</label>
			<select name="via_city">
				<option value=""></option>
				{% for dest in dest_cities %}
					{% for name,value in dest %}
						<option value="{{ value|e }}">{{ value|e }}</option>
					{% endfor %}
				{% endfor %}
			</select>
			<br>
			<a href="#" class="submit btn btn-primary">Submit</a>
		</form>
	</div>
	
</div>

<br><br>
<div id="results">
	
</div>

<div id="loading" class="row text-center" style="display:none">
  <img src="/img/loading.gif">
</div>
<br><br>


<script>
	$(document).ready(function() {

		$('.submit').click(function(e) {
			var $form = $(this).closest('form');
			var data = $form.serialize() + '&' + $('#cities').serialize();

			$.ajax({
				type		: "POST",
				url			: $form.attr('action'),
				data		: data,
				beforeSend	: function() {
					$('#loading').show();
					$('#results').html('');
				},
				complete	: function() {
					$('#loading').hide();
				},
				success		: function(response) {
					$('#results').html(response);
				}
			});


			e.preventDefault();
		});

	});
</script>