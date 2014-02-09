@section('main')

	{{ Former::vertical_open()->method('POST')->action(route('admin.pages.index'))->role('form') }}
		@include('pages.admin._form')
	{{ Former::close() }}

@stop