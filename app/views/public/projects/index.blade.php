@section('main')

	<h1>Projects</h1>

	@if (count($models))
	
	<ul>
		@foreach($models as $model)
		<li>
			{{ $model->title }} {{ $model->start_date }}
			{{ link_to_route($lang.'.projects.categories.slug', 'More', array($model->category->slug, $model->slug)) }}
		</li>
		@endforeach
	</ul>

	@endif

@stop