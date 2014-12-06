{{ content() }}

<header class="jumbotron subhead" id="overview">
	<div class="hero-unit">
		<h1>Welcome!</h1>
		<p class="lead">This is a website that allows you to search our flight database</p>
	</div>
</header>

<div class="row">

	<div class="span3">
		<h3>Cheapest Fares</h3>
		<div>
			{{ link_to('one/', '<i class="icon-ok icon-white"></i> Find Cheap Fares', 'class': 'btn btn-primary btn-large') }}
		</div>
	</div>

	<div class="span3">
		<h3>Shortest Routes</h3>
		<div>
			{{ link_to('two/', '<i class="icon-ok icon-white"></i> Find Short Routes', 'class': 'btn btn-primary btn-large') }}
		</div>
	</div>

	<div class="span3">
		<h3>Special Routes</h3>
		<div>
			{{ link_to('three/', '<i class="icon-ok icon-white"></i> Special Searches', 'class': 'btn btn-primary btn-large') }}
		</div>
	</div>

	<div class="span3">
		<h3>Modifications</h3>
		<div>
			{{ link_to('three/', '<i class="icon-ok icon-white"></i> Update the DB', 'class': 'btn btn-primary btn-large') }}
		</div>
	</div>
	

</div>
