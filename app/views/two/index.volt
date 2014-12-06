<h1>Shortest Routes</h1>

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
		<form id="option-A" action="/query/twoa">
			
			<label>Find Minimum Distance</label>
			<a href="#" class="submit btn btn-primary">Submit</a>
		</form>
	</div>

	<div class="span3">
		<h3>Option B</h3>
		<form id="option-B" action="/query/twob">
			
			<label>Find Minimum Stops</label>
			<a href="#" class="submit btn btn-primary">Submit</a>
		</form>
	</div>

	<div class="span3">
		<h3>Option C</h3>
		<form id="option-C" action="/query/twoc">
			
			<label>Shortest Time in Air</label>
			<p>(Doesn't include layover time)</p>
			<a href="#" class="submit btn btn-primary">Submit</a>
		</form>
	</div>

	<div class="span3">
		<h3>Option D</h3>
		<form id="option-D" action="/query/twod">
			
			<label>Shortest Total Time</label>
			<p>(Includes layover time)</p>
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