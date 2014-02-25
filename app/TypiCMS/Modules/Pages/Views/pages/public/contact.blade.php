@section('main')

	{{ $model->body }}

	@include('files.public._list', array('files' => $model->files))

@stop
