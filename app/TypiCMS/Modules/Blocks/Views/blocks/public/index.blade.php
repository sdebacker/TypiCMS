@section('main')

    <h2>{{ Str::title(trans_choice('blocks::global.blocks', 2)) }}</h2>

    <div class="row blocks">
        @foreach ($blocks as $block)
        <div class="col-xs-4 col-sm-3 col-md-2">
            <a href="{{ route($lang.'.blocks.slug', $block->slug) }}" class="thumbnail">
                <div class="img-container">
                    <img class="img-responsive" src="{{ $block->present()->thumb(null, 200, array(), 'logo') }}" alt="">
                </div>
                <div class="caption">
                    <p><small>{{ $block->title }}</small></p>
                </div>
            </a>
        </div>
        @endforeach
    </div>

@stop
