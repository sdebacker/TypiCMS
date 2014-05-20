
@section('main')

    <article>
        <h2>{{ $model->title }}</h2>
        <p class="lead summary">{{ nl2br($model->summary) }}</p>
        <div>{{ $model->body }}</div>
    </article>
    @if ($model->files->count())
        <div class="row">
        @foreach ($model->files as $image)
            <div class="col-xs-4 col-sm-3 col-md-2">
                <div class="thumbnail">
                    <a class="fancybox" href="/uploads/{{ $image->filename }}" data-fancybox-group="{{ $model->slug }}">
                        <img class="img-responsive" src="{{ Croppa::url('/uploads/' . $image->filename, 200, 200) }}" alt="">
                    </a>
                </div>
            </div>
        @endforeach
        </div>
    @endif

@stop
