<h1>Cheapest Fares</h1>

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
		<form id="option-A" action="/query/onea">
			
			<label>Exact Number of Stops</label>
			<input type="number" name="stops" value="0" min="0">
			<br><br>
			<a href="#" class="submit btn btn-primary">Submit</a>
		</form>
	</div>

	<div class="span3">
		<h3>Option B</h3>
		<form id="option-B" action="/query/oneb">
			
			<label>Maximum Number of Stops</label>
			<input type="number" name="stops" value="0" min="0">
			<br><br>
			<a href="#" class="submit btn btn-primary">Submit</a>
		</form>
	</div>

	<div class="span3">
		<h3>Option C</h3>
		<form id="option-C" action="/query/onec">
			
			<label>Maximum stop-over in hours</label>
			<input name="stopover" value="0" type="number" min="0">
			<br><br>
			<a href="#" class="submit btn btn-primary">Submit</a>
		</form>
	</div>

	<div class="span3">
		<h3>Option D</h3>
		<form id="option-D" action="/query/oned">
			
			<label>Do NOT stop in this city</label>
			<select name="stop_city">
				<option value=""></option>
				{% for dest in dest_cities %}
					{% for name,value in dest %}
						<option value="{{ value|e }}">{{ value|e }}</option>
					{% endfor %}
				{% endfor %}
			</select>
			<br><br>
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
