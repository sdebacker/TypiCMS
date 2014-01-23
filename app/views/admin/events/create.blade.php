@section('main')

	{{ Former::vertical_open()->method('POST')->action('admin/events/')->role('form') }}
		@include('admin.events._form')
	{{ Former::close() }}

@stop