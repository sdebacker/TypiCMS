@section('main')

	<h2>{{ Str::title(trans_choice('events::global.events', 2)) }}</h2>

	@if (count($models))
	<ul>
		@foreach($models as $model)
		<li>
			{{ $model->title }}
			<br>
			{{ $model->start_date }}@if($model->end_date) > {{ $model->end_date }} @endif
			<br>
			<a href="{{ route($lang.'.'.'events'.'.slug', $model->slug) }}">@lang('db.More')</a>
		</li>
		@endforeach
	</ul>
	@endif
@stop