
@section('main')

	<h1>titre : {{ $model->title }}</h1>
	<p>Date début : {{ $model->date }}</p>
	<p>Heure début : {{ $model->time }}</p>

@stop

@section('files')
	<div>
		{{ $files }}
	</div>
@stop