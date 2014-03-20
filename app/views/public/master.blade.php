<!doctype html>
<html lang="fr">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>{{ $title }}</title>

    {{ HTML::style(asset('css/public.css')) }}
    {{ HTML::style(asset('vendor/fancybox/source/jquery.fancybox.css')) }}

    @yield('css')

    {{ HTML::script(asset('vendor/jquery-legacy/jquery.js')) }}
    {{ HTML::script(asset('vendor/bootstrap/js/dropdown.js')) }}
    {{ HTML::script(asset('vendor/fancybox/source/jquery.fancybox.pack.js')) }}

    @yield('js')

    @if(Config::get('typicms.typekitCode'))
    <script type="text/javascript" src="//use.typekit.net/{{ Config::get('typicms.typekitCode') }}.js"></script>
    <script type="text/javascript">try{Typekit.load();}catch(e){}</script>
    @endif

    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    {{ HTML::script(asset('js/public.js')) }}

</head>

<body>

    <a href="#content" class="sr-only">@lang('db.Skip to content')</a>

    {{ $navBar }}

    <div class="container" id="content">

        @section('header')
        <header>
            <h1><a href="/{{ $lang }}">{{ Config::get('typicms.' . $lang . '.websiteTitle') }}</a></h1>
        </header>
        @show

        @section('languagesMenu')
        <nav role="navigation">
            {{ TypiCMS::languagesMenu(array('class' => 'nav nav-pills pull-right')) }}
        </nav>
        @show

        @section('mainMenu')
        <nav role="navigation">
            {{ Menu::build('main') }}
        </nav>
        @show

        @yield('main')

        @section('footer')
        <div class="row">
            <div class="col-sm-4">
                {{ Menu::build('social', array('id' => 'social')) }}
            </div>
            <nav class="col-sm-8" role="navigation">
                {{ Menu::build('footer') }}
            </nav>
        </div>
        @show

    </div>
    
    @if(App::environment() == 'production')

        @if(Config::get('typicms.googleAnalyticsUniversalCode'))

        <script>
            (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
            (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
            })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

            ga('create', '{{ Config::get('typicms.googleAnalyticsUniversalCode') }}', '{{ Request::server('SERVER_NAME') }}');
            ga('send', 'pageview');

        </script>

        @elseif(Config::get('typicms.googleAnalyticsCode'))

        <script>
            var _gaq=[['_setAccount','{{ Config::get('typicms.googleAnalyticsCode') }}'],['_trackPageview']];
            (function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
            g.src='//www.google-analytics.com/ga.js';
            s.parentNode.insertBefore(g,s)}(document,'script'));
        </script>

        @endif

    @endif

</body>

</html>