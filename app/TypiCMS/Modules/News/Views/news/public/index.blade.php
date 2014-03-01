@section('main')

	<h2>{{ Str::title(trans_choice('news::global.news', 2)) }}</h2>

	@if (count($models))
	<ul>
		@foreach($models as $model)
		<li>
			{{ $model->title }} {{ $model->date }}
			<a href="{{ route($lang.'.'.'news'.'.slug', $model->slug) }}">More</a>
		</li>
		@endforeach
	</ul>
	@endif
@stop