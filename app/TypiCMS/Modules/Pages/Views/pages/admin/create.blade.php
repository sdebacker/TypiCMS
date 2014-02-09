@section('main')

	{{ Form::open( array( 'route' => array('admin.pages.index'), 'method' => 'post' ) ) }}
		@include('pages.admin._form')
	{{ Form::close() }}

@stop