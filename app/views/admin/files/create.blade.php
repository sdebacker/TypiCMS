@section('main')

	{{ Former::vertical_open()->method('POST')->action('admin/files/')->role('form') }}
		@include('admin.files._form')
	{{ Former::close() }}

@stop