<!doctype html>
<html lang="fr">

<head>

	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
	<title>{{ $title }}</title>

	{{ basset_stylesheets('admin') }}

	@yield('css')

	<script src="http://code.jquery.com/jquery-2.0.3.min.js"></script>

	{{ basset_javascripts('admin') }}

	{{ HTML::script(asset('js/general.js')) }}

	@yield('js')
	@yield('head')

</head>

<body>

{{ $navBar }}

<div class="container-global col-xs-12">

	@yield('menu')

	<script type="text/javascript">
		{{ Notification::showError('alertify.error(":message");') }}
		{{ Notification::showInfo('alertify.log(":message");') }}
		{{ Notification::showSuccess('alertify.success(":message");') }}
	</script>

	@yield('header')

	<div class="btn-group pull-right">
		@foreach (Config::get('app.locales') as $locale)
			<a class="btn btn-default btn-sm @if($locale == Session::get('locale')) active @endif" href="?locale={{ $locale }}">{{ $locale }}</a>
		@endforeach
	</div>

	@yield('buttons')

	@yield('main')

	@include('admin._footer')

</div>

</body>

</html>