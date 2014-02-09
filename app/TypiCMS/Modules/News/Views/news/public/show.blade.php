
@section('main')

	<h1>titre : {{ $model->title }}</h1>
	<p>Date début : {{ $model->date }}</p>
	<p>Heure début : {{ $model->time }}</p>

	@include('files.public._list', array('files' => $model->files))

@stop
