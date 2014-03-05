<!doctype html>
<html lang="fr">

<head>

	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
	<title>{{ $title }}</title>

	{{-- CSS --}}

	{{ HTML::style(asset('vendor/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css')) }}
	{{ HTML::style(asset('vendor/alertify.js/themes/alertify.core.css')) }}
	{{ HTML::style(asset('vendor/alertify.js/themes/alertify.bootstrap.css')) }}
	{{ HTML::style(asset('vendor/select2/select2.css')) }}
	{{ HTML::style(asset('vendor/select2/select2-bootstrap.css')) }}

	@yield('css')

	{{ HTML::style(asset('css/admin.css')) }}

	{{-- JS --}}

	{{ HTML::script(asset('vendor/jquery/jquery.js')) }}
	{{ HTML::script(asset('vendor/jquery-ui/ui/minified/jquery-ui.min.js')) }}
	{{ HTML::script(asset('vendor/jquery-ui/ui/minified/jquery.ui.core.min.js')) }}
	{{ HTML::script(asset('vendor/jquery-ui/ui/minified/jquery.ui.mouse.min.js')) }}
	{{ HTML::script(asset('vendor/jquery-ui/ui/minified/jquery.ui.widget.min.js')) }}
	{{ HTML::script(asset('vendor/jquery-ui/ui/minified/jquery.ui.sortable.min.js')) }}
	{{ HTML::script(asset('vendor/alertify.js/lib/alertify.min.js')) }}
	{{ HTML::script(asset('vendor/select2/select2.min.js')) }}
	@if(Config::get('app.locale') != 'en')
	{{ HTML::script(asset('vendor/select2/select2_locale_'.Config::get('app.locale').'.js')) }}
	@endif
	{{ HTML::script(asset('vendor/dropzone/downloads/dropzone.min.js')) }}
	{{ HTML::script(asset('vendor/bootstrap/js/dropdown.js')) }}
	{{ HTML::script(asset('vendor/bootstrap/js/tab.js')) }}
	{{ HTML::script(asset('vendor/moment/moment.js')) }}
	{{ HTML::script(asset('vendor/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js')) }}
	@if(Config::get('app.locale') != 'en')
	{{ HTML::script(asset('vendor/eonasdan-bootstrap-datetimepicker/src/js/locales/bootstrap-datetimepicker.'.Config::get('app.locale').'.js')) }}
	@endif
	{{ HTML::script(asset('components/jquery.mjs.nestedSortable.js')) }}
	{{ HTML::script(asset('components/jquery.nestedCookie.js')) }}
	{{ HTML::script(asset('components/jquery.listenhancer.js')) }}
	{{ HTML::script(asset('components/jquery.slug.js')) }}
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

	
	@section('breadcrumbs')
	{{ Breadcrumbs::renderIfExists() }}
	@show

	@section('page-header')
	<div class="page-header">
		<h1>
		@yield('addButton')
			@section('h1')
			{{ $h1 }}
			@show
		@yield('titleSmall')
		</h1>
	</div>
	@show

	@yield('buttons')

	@yield('main')

	@include('admin._footer')

</div>

</body>

</html>