{% if results is empty %}
	<h3>No Results</h3>
{% else %}
	{% for result in results %}
		<h3>
			{% set total = 0 %}
			{% for array in result %}
				{% set total += array['airfare'] %}
			{% endfor %}
			Total Airfare: {{ total }}
			
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