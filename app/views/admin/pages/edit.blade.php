@section('titleSmall')
	<small>{{ $model->uri }}</small>
@stop

@section('main')

		{{ Former::vertical_open()->method('PATCH')->action(route('admin.pages.update', $model->id))->role('form') }}
			@include('admin.'.$model->view.'._form')
		{{ Former::close() }}

@stop