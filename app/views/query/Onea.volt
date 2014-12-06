<h3>
	Total Airfare: 
	{% if total is empty %}
	{% else %}
		{% for t in total %}
			{% for name,value in t %}
				{{ value }}
			{% endfor %}
		{% endfor %}
	{% endif %}
</h3>
{% if totalStop is empty %}
{% else %}
	<h3>Total Stopover in minutes:
		{% for ts in totalStop %}
			{% for name,value in ts %}
				{{ value }}
			{% endfor %}
		{% endfor %}
	</h3>
{% endif %}
<table class="table table-striped table-hover table-bordered table-condensed">
	<thead>
		<tr>
			{% if columns is empty %}
				<th>No Results</th>
			{% else %}
				<th>#</th>
			{% endif %}
			{% for column in columns %}
				<th>{{ column|e }}</th>
			{% endfor %}
		</tr>
	</thead>
	<tbody>
		{% for result in results %}
			<tr>
				<td>{{ loop.index }}</td>
				{% for name,value in result %}
					<td>{{ value }}</td>
				{% endfor %}
			</tr>
		{% endfor %}
	</tbody>

</table>