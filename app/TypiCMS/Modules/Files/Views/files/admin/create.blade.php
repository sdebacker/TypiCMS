@section('main')

	{{ Form::open( array( 'route' => array('admin.files.index'), 'method' => 'post', 'role' => 'form' ) ) }}
		@include('files.admin._form')
	{{ Form::close() }}

@stop