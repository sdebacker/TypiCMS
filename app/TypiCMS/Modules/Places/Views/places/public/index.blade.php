@section('js')
    {{ HTML::script(asset('//maps.googleapis.com/maps/api/js?sensor=false&amp;language='.Config::get('app.locale'))) }}
    {{ HTML::script(asset('js/public/gmaps.js')) }}
@stop

@section('main')

    <h2>{{ Str::title(trans_choice('places::global.places', 2)) }}</h2>

    <div class="row">

        <div class="col-sm-4">

            <form method="get" role="form">
                <label for="string" class="sr-only">@lang('db.Search')</label>
                <div class="input-group">
                    <input id="string" type="text" placeholder="{{ trans('db.Search') }}" name="string" value="{{ Input::get('string') }}" class="form-control input-sm">
                    <span class="input-group-btn">
                        <button type="submit" class="btn btn-sm btn-primary">@lang('db.Search')</button>
                    </span>
                </div>
            </form>

            <h3>
            {{ $places->count() }} @choice('places::global.places', $places->count())
            @if(Input::get('string')) @lang('for')
                “{{ Input::get('string') }}”
            @endif
            </h3>

            <ul class="list-unstyled addresses">
                @foreach ($places as $place)
                <li id="item-{{ $place->id }}">
                    <div class="btns">
                        @if ($place->latitude && $place->longitude)
                        <a class="btn-map" href="" title="{{ trans('db.Show on map') }}"><i class="fa fa-map-marker"></i><span class="sr-only">{{ trans('db.Show on map') }}</span></a>
                        @endif
                        <a href="{{ route($lang.'.places.slug', array($place->slug)) }}" title="{{ trans('db.More') }}"><span class="fa fa-plus"></span><span class="sr-only">{{ trans('db.More') }}</span></a>
                    </div>
                    {{ $place->title }}
                </li>
                @endforeach
            </ul>

        </div>

        <div class="col-sm-8">
            <div id="map" class="map"></div>
        </div>

    </div>

@stop
