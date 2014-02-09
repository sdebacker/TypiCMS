
@section('main')

	<h2>titre : {{ $model->title }}</h2>

	@include('files.public._list', array('files' => $model->files))

@stop
