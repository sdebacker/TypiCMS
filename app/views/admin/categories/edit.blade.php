@section('main')

	{{ Former::vertical_open()->method('PATCH')->action('admin/'.$model->view.'/'.$model->id)->role('form') }}
		@include('admin.'.$model->view.'._form')
	{{ Former::close() }}

@stop