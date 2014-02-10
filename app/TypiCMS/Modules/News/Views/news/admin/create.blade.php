@section('main')

	{{ Form::open( array( 'route' => array('admin.news.index'), 'method' => 'post', 'role' => 'form' ) ) }}
		@include('news.admin._form')
	{{ Form::close() }}

@stop