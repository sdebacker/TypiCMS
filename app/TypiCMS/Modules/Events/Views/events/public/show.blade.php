
@section('main')

	<article>
		<h2>{{ $model->title }}</h2>
		<div class="date">{{ $model->date_from_to }}</div>
		<p>Heure début : {{ $model->start_time }}</p>
		<p>Heure fin : {{ $model->end_time }}</p>
		<p class="summary">{{ nl2br($model->summary) }}</p>
		<div>{{ $model->body }}</div>
		@include('files.public._list', array('files' => $model->files))
	</article>

@stop
