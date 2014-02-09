@section('main')

	{{ Former::vertical_open()->method('POST')->action('admin/files/')->role('form') }}
		@include('files.admin._form')
	{{ Former::close() }}

@stop