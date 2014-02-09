@section('main')

	{{ Former::vertical_open()->method('PATCH')->action('admin/categories/'.$model->id)->role('form') }}
		@include('categories.admin._form')
	{{ Former::close() }}

@stop