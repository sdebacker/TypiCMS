@section('main')

   <!-- 
<h2>{{ Str::title(trans_choice('news::global.news', $models->getTotal())) }}</h2>  
-->
<p>

<p>
    @if ($models->count())
    <ul>
        @foreach ($models as $model)
        <li>
            <strong><a href="{{ route($lang.'.news.slug', $model->slug) }}" class="btn btn-default btn-xs">{{ $model->title }}</a></strong>
<p>
<!--
            <div class="date">@lang('news::global.Published on') 
                <time datetime="{{ $model->date }}">{{ $model->present()->dateLocalized }}</time>
            </div>
-->
<!--
            <a href="{{ route($lang.'.news.slug', $model->slug) }}">@lang('db.More')</a>
-->
        </li>
        @endforeach
    </ul>
    @endif

    {{ $models->appends(Input::except('page'))->links() }}

@stop
