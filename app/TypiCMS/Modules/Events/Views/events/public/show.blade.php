
@section('main')

    <article>
        <h2>{{ $model->title }}</h2>
        <div class="date">{{ $model->present()->dateFromTo }} <br>{{ $model->present()->timeFromTo }}</div>
        <p class="summary">{{ nl2br($model->summary) }}</p>
        <div>{{ $model->body }}</div>
    </article>

@stop
