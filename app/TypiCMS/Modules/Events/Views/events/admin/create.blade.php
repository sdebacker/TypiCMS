@section('main')

	{{ Form::open( array( 'route' => array('admin.events.index'), 'method' => 'post', 'role' => 'form' ) ) }}
		@include('events.admin._form')
	{{ Form::close() }}

@stop