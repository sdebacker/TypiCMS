@section('main')

	<h2>{{ Str::title(trans_choice('projects::global.projects', 2)) }}</h2>

	@if (count($models))
	
	<ul>
		@foreach($models as $model)
		<li>
			{{ $model->title }} {{ $model->start_date }}
			{{ link_to_route($lang.'.projects.categories.slug', trans('db.More'), array($model->category->slug, $model->slug)) }}
		</li>
		@endforeach
	</ul>

	@endif

@stop