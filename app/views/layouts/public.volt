<div class="navbar">
	<div class="navbar-inner">
		<div class="container" style="width: auto;">
			<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</a>
			{{ link_to(null, 'class': 'brand', 'flightDB')}}
			<div class="nav-collapse">
				<ul class="nav">

					{%- set menus = [
						'Home': 'index',
						'One': 'one',
						'Two': 'two',
						'Three':'three'
					] -%}

					{%- for key, value in menus %}
						{% if value == dispatcher.getControllerName() %}
							<li class="active">{{ link_to(value, key) }}</li>
						{% else %}
							<li>{{ link_to(value, key) }}</li>
						{% endif %}
					{%- endfor -%}
					<li class="{% if "four" == dispatcher.getControllerName() %}active {% endif %}dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Four <span class="caret"></span></a>
						<ul class="dropdown-menu" role="menu">
							<li><a href="/four/a">a</a></li>
							<li><a href="/four/b">b</a></li>
							<li><a href="/four/c">c</a></li>
							<li><a href="/four/d">d</a></li>
							<li><a href="/four/e">e</a></li>
							<li><a href="/four/f">f</a></li>
						</ul>
					</li>
				</ul>

				<ul class="nav pull-right">
				</ul>
			</div><!-- /.nav-collapse -->
		</div>
	</div><!-- /navbar-inner -->
</div>

<div class="container main-container">
	{{ content() }}
</div>

<footer>
Made with love by Dustin Maxfield.
</footer>