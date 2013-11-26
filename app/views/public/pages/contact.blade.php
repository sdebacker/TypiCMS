@section('main')

	<h2 class="sr-only">{{ $model->title }}</h2>
	{{ $model->body }}
	template contact

	@include('public.files._list', array('files' => $model->files))

@stop
