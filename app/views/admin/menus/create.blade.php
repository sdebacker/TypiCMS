@section('main')

	{{ Former::vertical_open()->method('POST')->action('admin/menus/')->role('form') }}
		@include('admin.menus._form')
	{{ Former::close() }}

@stop