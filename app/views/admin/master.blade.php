<!doctype html>
<html lang="fr">

<head>

	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
	<title>{{ $title }}</title>

	{{ basset_stylesheets('admin') }}

	{{ HTML::style(asset('plugins/uploader/css/jquery.uploader.css')) }}
	@yield('css')

	<script src="http://code.jquery.com/jquery-2.0.3.min.js"></script>

	{{ basset_javascripts('admin') }}

	{{ HTML::script(asset('plugins/uploader/js/jquery.uploader.js')) }}

	{{ HTML::script(asset('js/general.js')) }}

	@yield('js')
	@yield('head')

</head>

<body>

@include('_navbar')

<div class="container-global col-xs-12">
ee
	@yield('menu')

	<script type="text/javascript">
		{{ Notification::showError('alertify.error(":message");') }}
		{{ Notification::showInfo('alertify.log(":message");') }}
		{{ Notification::showSuccess('alertify.success(":message");') }}
	</script>

	@yield('buttons')

	@yield('header')

	@yield('main')

	@include('admin._footer')

</div>

</body>

</html>