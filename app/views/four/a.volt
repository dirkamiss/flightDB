{{ content() }}

<h1>Insert Crew Member Record</h1>



<form method="post" class="form-horizontal" action="">

	<div class="form-group">
		<div class="span6">
			<label>ID</label>
			<input name="id" type="number" min="0">
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
		<input name="hours" type="number" min="0" step="50">
		<label>Supervisor</label>
		<input name="supervisor" type="number" min="0">
		<label>Aircrafts Certified to Fly (comma separated)</label>
		<input name="certified" type="text">

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
					<th>Enter Flight Number</th>
				</tr>
			</thead>
		{% endif %}
		<tbody>
			<tr>
				{% for name,value in c %}
					<td>{{ value }}</td>
				{% endfor %}
				<td>
					<div>
						<input type="number" min="101" max="999" style="width:30%">
						<a href="/four/assign/{{c['crew_id']}}/" class="assign btn">Assign</a>
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

	});
</script>