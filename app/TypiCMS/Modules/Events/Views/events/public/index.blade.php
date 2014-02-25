@section('main')

	<h2>{{ Str::title(trans_choice('modules.events.events', 2)) }}</h2>

	@if (count($models))
	<ul>
		@foreach($models as $model)
		<li>
			{{ $model->title }}
			<br>
			{{ $model->start_date }}@if($model->end_date) > {{ $model->end_date }} @endif
			<br>
			<a href="{{ route($lang.'.'.'events'.'.slug', $model->slug) }}">@lang('public.More')</a>
		</li>
		@endforeach
	</ul>
	@endif
@stop