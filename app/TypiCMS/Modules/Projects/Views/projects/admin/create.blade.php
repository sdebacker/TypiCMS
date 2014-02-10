@section('main')

	{{ Form::open( array( 'route' => array('admin.projects.index'), 'method' => 'post', 'role' => 'form', 'class' => 'col-sm-6' ) ) }}
		@include('projects.admin._form')
	{{ Form::close() }}

@stop