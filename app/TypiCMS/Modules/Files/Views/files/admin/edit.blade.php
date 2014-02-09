@section('main')

	{{ Former::vertical_open()->method('PATCH')->action('admin/'.$model->view.'/'.$model->id)->role('form') }}
		@include('files.admin._form')
	{{ Former::close() }}

@stop