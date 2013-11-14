@section('main')
	<h1>Events</h1>
	@if (count($models))
	<ul>
		@foreach($models as $model)
		<li>
			{{ $model->title }}
			<br>
			{{ $model->start_date }}@if($model->end_date) > {{ $model->end_date }} @endif
			<br>
			<a href="{{ route($lang.'.'.'events'.'.slug', $model->slug) }}">{{ trans('public.More') }}</a>
		</li>
		@endforeach
	</ul>
	@endif
@stop