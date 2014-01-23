@section('main')

	{{ Former::vertical_open()->method('POST')->action(route('admin.projects.index'))->role('form') }}
		@include('admin.projects._form')
	{{ Former::close() }}

@stop