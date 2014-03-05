
@section('main')

	<h2>titre : {{ $model->title }}</h2>
	<div class="date">{{ $model->date_from_to }}</div>
	<p>Heure début : {{ $model->start_time }}</p>
	<p>Heure fin : {{ $model->end_time }}</p>

	@include('files.public._list', array('files' => $model->files))

@stop
