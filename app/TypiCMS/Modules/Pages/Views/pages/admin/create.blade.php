@section('main')

	{{ Former::vertical_open()->method('POST')->action(route('admin.pages.index'))->role('form') }}
		@include('admin.pages._form')
	{{ Former::close() }}

@stop