@section('main')

	{{ Former::vertical_open()->method('POST')->action('admin/events/')->role('form') }}
		@include('events.admin._form')
	{{ Former::close() }}

@stop