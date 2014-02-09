@section('main')

	{{ Former::vertical_open()->method('PATCH')->action('admin/menus/'.$model->id)->role('form') }}
		@include('menus.admin._form')
	{{ Former::close() }}

@stop