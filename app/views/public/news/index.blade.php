@section('main')

	<h1>News</h1>
	@if (count($models))
	<ul>
		@foreach($models as $model)
		<li>
			{{ $model->title }} {{ $model->date->format('d.m.Y') }} {{ $model->time }}
			<a href="{{ route($lang.'.'.'news'.'.slug', $model->slug) }}">More</a>
		</li>
		@endforeach
	</ul>
	@endif
@stop