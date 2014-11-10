@section('js')
    {{ HTML::script(asset('//maps.googleapis.com/maps/api/js?sensor=false&amp;language='.Config::get('app.locale'))) }}
    {{ HTML::script(asset('js/public/gmaps.js')) }}
@stop

@section('main')

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

@stop
