@section('main')

	{{ Former::vertical_open()->method('POST')->action('admin/users/')->role('form') }}
		@include('admin.users._form')
	{{ Former::close() }}

@stop