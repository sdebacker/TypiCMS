@section('main')

	{{ Former::vertical_open_for_files()->method('POST')->action('admin/places/')->role('form') }}
		@include('places.admin._form')
	{{ Former::close() }}

@stop