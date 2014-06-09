
@section('main')

    <article>
        <h2>{{ $model->title }}</h2>
        <div class="date">{{ $model->present()->dateFromTo }} <br>{{ $model->present()->timeFromTo }}</div>
        <p class="summary">{{ nl2br($model->summary) }}</p>
        <a class="btn btn-default btn-xs" href="{{ route($lang.'.events.slug.ics', $model->slug) }}">
            <span class="fa fa-calendar"></span> @lang('db.Add to calendar')
        </a>
        <div>{{ $model->body }}</div>
    </article>

@stop
