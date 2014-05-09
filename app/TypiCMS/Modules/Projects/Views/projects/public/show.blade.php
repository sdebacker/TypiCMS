
@section('main')

    <article>
        <h2>{{ $model->title }}</h2>
        <p class="summary">{{ nl2br($model->summary) }}</p>
        <div>{{ $model->body }}</div>
    </article>

@stop
