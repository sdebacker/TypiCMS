@section('main')

    <h2>{{ Str::title(trans_choice('events::global.events', 2)) }}</h2>

    @if (count($models))
    <ul>
        @foreach ($models as $model)
        <li>
            <strong>{{ $model->title }}</strong>
            <div class="date">{{ $model->date_from_to }}</div>
            <a href="{{ route($lang.'.events.slug', $model->slug) }}">@lang('db.More')</a>
        </li>
        @endforeach
    </ul>
    @endif

    {{ $models->appends(Input::except('page'))->links() }}

@stop