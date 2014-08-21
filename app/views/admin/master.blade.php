<!doctype html>
<html lang="{{ Config::get('typicms.adminLocale') }}">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">

    <title>{{ $title }}</title>

    @yield('css')
    {{ HTML::style(asset('css/admin.css')) }}

    {{ HTML::script(asset('js/components.min.js')) }}

    @if(Config::get('typicms.adminLocale') != 'en')
        {{ HTML::script(asset('js/pickadate-locales/' . Config::get('typicms.adminLocale') . '_' . strtoupper(Config::get('typicms.adminLocale')) . '.js')) }}
    @endif

    {{ HTML::script(asset('js/admin/components-admin.min.js')) }}

    @yield('js')

    {{ HTML::script(asset('js/admin/master.js')) }}

</head>

<body class="@section('bodyClass')has-navbar @show">

@section('navbar')
    @if (Sentry::getUser())
        @include('_navbar')
    @endif
@show

<div class="container-fluid">

    <div class="row row-offcanvas row-offcanvas-left">

        @section('sidebar')
            @include('admin._sidebar')
        @show

        <div class="@section('mainClass')col-xs-12 col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main @show">

            <script type="text/javascript">
                {{ Notification::showError('alertify.error(\':message\');') }}
                {{ Notification::showInfo('alertify.log(\':message\');') }}
                {{ Notification::showSuccess('alertify.success(\':message\');') }}
            </script>

            @section('page-header')

                @section('btn-offcanvas')
                <p class="pull-left visible-xs btn-toggle-offcanvas">
                    <button class="btn btn-link" data-toggle="offcanvas"><span class="fa fa-bars fa-lg"></span> <span class="sr-only">@lang('global.Toggle navigation')</span></button>
                </p>
                @show
                
                @section('breadcrumbs')
                {{-- Breadcrumbs::renderIfExists() --}}
                @show

                <div class="page-header">
                    <h1>
                        @yield('titleLeftButton')
                        @section('h1')
                        {{ $h1 }}
                        @show
                        @yield('titleSmall')
                    </h1>
                </div>
            @show

            @yield('main')

        </div>

        @include('admin._footer')

    </div>

</div>

</body>

</html>