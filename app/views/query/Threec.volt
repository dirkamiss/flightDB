{% if results is empty %}
	<h3>No Results</h3>
{% else %}
	{% for result in results %}
		<h3>
			Departure Time: {{ result[0]['departure_time'] }}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Arrival Time: {{ result[result|length-1]['arrival_time'] }}
		</h3>
		<table class="table table-striped table-hover table-bordered table-condensed">
			<thead>
				<tr>
					{% for name,value in result[0] %}
						<th>{{ name }}</th>
					{% endfor %}
				</tr>
			</thead>
			<tbody>
				{% for array in result %}
					<tr>
						{% for name,value in array %}
							<td>{{ value }}</td>
						{% endfor %}
					</tr>
				{% endfor %}
			</tbody>

		</table>
	{% endfor %}
{% endif %}