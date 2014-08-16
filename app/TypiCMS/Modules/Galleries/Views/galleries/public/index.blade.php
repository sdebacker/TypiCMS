@section('main')

    <h2>{{ Str::title(trans_choice('galleries::global.galleries', 2)) }}</h2>

    @if ($models->count())
    <ul>
        @foreach ($models as $model)
        <li>
            <strong>{{ $model->title }}</strong>
            <div class="date">{{ $model->present()->dateFromTo }}</div>
            <a href="{{ route($lang.'.galleries.slug', $model->slug) }}">@lang('db.More')</a>
        </li>
        @endforeach
    </ul>
    @endif

    {{ $models->appends(Input::except('page'))->links() }}

@stop
