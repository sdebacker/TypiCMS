@section('main')

    <h2>{{ Str::title(trans_choice('partners::global.partners', 2)) }}</h2>

    <div class="row partners">
        @foreach ($partners as $partner)
        <div class="col-xs-4 col-sm-3 col-md-2">
            <a href="{{ route($lang.'.partners.slug', $partner->slug) }}" class="thumbnail">
                <div class="img-container">
                    <img class="img-responsive" src="{{ $partner->present()->thumb(null, 200, array(), 'logo') }}" alt="">
                </div>
                <div class="caption">
                    <p><small>{{ $partner->title }}</small></p>
                </div>
            </a>
        </div>
        @endforeach
    </div>

@stop
