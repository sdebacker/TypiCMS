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
	<script type="text/javascript" src="{{ asset('plugins/respond.min.js') }}"></script>
	<![endif]-->

	{{ basset_javascripts('public') }}

	@yield('head')

</head>

<body>
	<a href="#content" class="sr-only">{{ trans('public.Skip to content') }}</a>

@include('_navbar')

<div class="container" id="content">

	<nav role="navigation" class="menu menu-languages pull-right">
		{{-- $languagesMenuList --}}
		<ul class="nav nav-pills">
			@foreach ($languagesMenu as $item)
				<li class="{{ $item->class }}">
					<a href="{{ $item->url }}">{{ $item->lang }}</a>
				</li>
			@endforeach
		</ul>
	</nav>

	@yield('menu')

	<nav role="navigation">
		{{ $mainMenu }}
	</nav>

	@yield('main')

	@include('public._footer')

</div>

</body>

</html>