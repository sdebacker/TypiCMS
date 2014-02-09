@section('main')

	{{ Former::vertical_open()->method('POST')->action('admin/menus/')->role('form') }}
		@include('menus.admin._form')
	{{ Former::close() }}

@stop