<!doctype html>
<html lang="fr">

<head>

	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
	<title>{{ $title }}</title>

	{{ basset_stylesheets('public') }}

	<script src="http://code.jquery.com/jquery-2.0.3.min.js"></script>

	@if(Config::get('app.typekitCode'))
	<script type="text/javascript" src="//use.typekit.net/{{ Config::get('app.typekitCode') }}.js"></script>
	<script type="text/javascript">try{Typekit.load();}catch(e){}</script>
	@endif

	<!--[if IE 8]>
	<script type="text/javascript" src="{{ asset('components/vendor/respond/respond.min.js') }}"></script>
	<![endif]-->

	{{ basset_javascripts('public') }}

	@yield('head')

</head>

<body>

	<a href="#content" class="sr-only">{{ trans('public.Skip to content') }}</a>

	{{ $navBar }}

	<div class="container" id="content">

		@section('header')
		<header>
			<h1>{{ link_to_route($lang, Config::get('settings.website_title')) }}</h1>
		</header>
		@show

		@section('languagesMenu')
		<nav role="navigation" class="menu menu-languages pull-right">
			{{-- $languagesMenuList --}}
			<ul class="nav nav-pills" role="menu">
				@foreach ($languagesMenu as $item)
					<li class="{{ $item->class }}" role="menuitem">
						<a href="{{ $item->url }}">{{ $item->lang }}</a>
					</li>
				@endforeach
			</ul>
		</nav>
		@show

		@yield('menu')

		@section('mainMenu')
		<nav role="navigation">
			{{ $mainMenu }}
		</nav>
		@show

		@yield('main')

		@yield('files')

		@section('footerMenu')
		@include('public._footer')
		@show

	</div>
	
	@if(Config::get('app.googleAnalyticsCode'))
	<script>
		var _gaq=[['_setAccount','{{ Config::get('app.googleAnalyticsCode') }}'],['_trackPageview']];
		(function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
		g.src='//www.google-analytics.com/ga.js';
		s.parentNode.insertBefore(g,s)}(document,'script'));
	</script>
	@endif

</body>

</html>