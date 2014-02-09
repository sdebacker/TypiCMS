@section('main')

	<h2 class="sr-only">{{ $model->title }}</h2>
	{{ $model->body }}
	template contact

	@include('files.public._list', array('files' => $model->files))

@stop
