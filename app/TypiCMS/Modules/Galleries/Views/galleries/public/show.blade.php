@section('main')

    @include('galleries.public._slider')

    <article>
        <h2>{{ $model->title }}</h2>
        <p class="lead summary">{{ nl2br($model->summary) }}</p>
        <div>{{ $model->body }}</div>
    </article>

    @include('galleries.public._thumbs')

@stop
