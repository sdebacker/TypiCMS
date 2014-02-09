
@section('main')

	<h1>titre : {{ $model->title }}</h1>
	<p>Date début : {{ $model->start_date }}</p>
	<p>Heure début : {{ $model->start_time }}</p>
	<p>Date fin : {{ $model->end_date }}</p>
	<p>Heure fin : {{ $model->end_time }}</p>

	@include('files.public._list', array('files' => $model->files))

@stop
