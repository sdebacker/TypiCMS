<!doctype html>
<html lang="fr">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">

    <title>{{ $title }}</title>

    @yield('css')
    {{ HTML::style(asset('css/admin.css')) }}

    {{ HTML::script(asset('js/admin/components.min.js')) }}

    @if(Config::get('app.locale') != 'en')
        {{ HTML::script(asset('js/datepicker-locales/bootstrap-datetimepicker.'.Config::get('app.locale').'.js')) }}
    @endif

    {{ HTML::script(asset('js/admin/components-custom.min.js')) }}

    @yield('js')

    {{ HTML::script(asset('js/admin/master.js')) }}

</head>

<body class="@yield('bodyClass')">

@section('navbar')
    @if (Sentry::getUser())
        @include('_navbar')
    @endif
@show

<div class="container-global col-xs-12">

    @yield('menu')

    <script type="text/javascript">
        {{ Notification::showError('alertify.error(\':message\');') }}
        {{ Notification::showInfo('alertify.log(\':message\');') }}
        {{ Notification::showSuccess('alertify.success(\':message\');') }}
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