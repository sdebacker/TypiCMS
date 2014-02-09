@section('main')

	{{ Former::vertical_open()->method('POST')->action('admin/categories/')->role('form') }}
		@include('categories.admin._form')
	{{ Former::close() }}

@stop