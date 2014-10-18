
@section('main')

    <article>
        <h2>{{ $model->title }}</h2>
        <div class="date">@lang('news::global.Published on') 
            <time datetime="{{ $model->date }}" pubdate>{{ $model->present()->dateLocalized }}</time>
        </div>
        <p class="summary">{{ nl2br($model->summary) }}</p>
        <div class="body">{{ $model->body }}</div>
    </article>

    @include('galleries.public._galleries')

@stop
