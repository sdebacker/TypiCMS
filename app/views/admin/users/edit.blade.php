@section('main')

	{{ Form::model( $model, array( 'route' => array('admin.users.update', $model->id), 'method' => 'patch', 'role' => 'form' ) ) }}
		@include('admin.users._form')
	{{ Form::close() }}

@stop