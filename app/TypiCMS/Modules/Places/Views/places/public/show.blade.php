<!doctype html>
<html lang="fr">

<head>

    <meta charset="utf-8">
    <title>{{ $model->title }}</title>

    {{ HTML::style(asset('css/gmaps.css')) }}
    {{ HTML::style(asset('css/public.css')) }}
    {{ HTML::style(asset('vendor/fancybox/source/jquery.fancybox.css')) }}

    {{ HTML::script(asset('vendor/jquery-legacy/jquery.js')) }}
    {{ HTML::script(asset('vendor/bootstrap/js/dropdown.js')) }}
    {{ HTML::script(asset('vendor/fancybox/source/jquery.fancybox.pack.js')) }}
    {{ HTML::script(asset('//maps.googleapis.com/maps/api/js?sensor=false&amp;language=fr')) }}
    {{ HTML::script(asset('js/gmaps.js')) }}

    @if(Config::get('typicms.typekitCode'))
    <script type="text/javascript" src="//use.typekit.net/{{ Config::get('typicms.typekitCode') }}.js"></script>
    <script type="text/javascript">try {Typekit.load();} catch (e) {}</script>
    @endif

    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->

    {{ HTML::script(asset('js/public.js')) }}

</head>

<body style="padding:0">

    <div class="row">
        <div class="col-sm-4">
            <h3>{{ $model->title }}</h3>

            @if($model->logo)
                <p><img src="{{ Croppa::url('/uploads/places/'.$model->logo, 0, 200) }}" alt=""></p>
            @endif

            <p>
                @if ($model->address)
                    {{ $model->address }}<br>
                @endif
                @if ($model->phone)
                    {{ $model->phone }}<br>
                @endif
                @if ($model->email)
                    <a href="mailto:{{ $model->email }}">{{ $model->email }}</a><br>
                @endif
                @if ($model->website)
                    <a href="{{ $model->website }}">{{ $model->website }}</a><br>
                @endif
            </p>
            <p>
                @if ($model->info)
                    {{ nl2br($model->info) }}
                @endif
            </p>
        </div>
        <div class="col-sm-8">
            @if($model->latitude && $model->longitude)
                <div id="map" class="map map-fancybox"></div>
            @endif
        </div>
    </div>

</body>

</html>
