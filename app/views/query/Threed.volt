{% if results is empty %}
	<h3>No Results</h3>
{% else %}
	{% for result in results %}
		<h3>
			Passengers: {{ result|length }}
		</h3>
		<table class="table table-striped table-hover table-bordered table-condensed">
			<thead>
				<tr>
					<th>#</th>
					{% for name,value in result[0] %}
						<th>{{ name }}</th>
					{% endfor %}
				</tr>
			</thead>
			<tbody>
				{% for array in result %}
					<tr>
						<td>{{ loop.index }}</td>
						{% for name,value in array %}
							<td>{{ value }}</td>
						{% endfor %}
					</tr>
				{% endfor %}
			</tbody>

		</table>
	{% endfor %}
{% endif %}