@section('main')

	{{ Form::model( $model, array( 'route' => array('admin.files.update', $model->id), 'method' => 'patch', 'role' => 'form' ) ) }}
		@include('files.admin._form')
	{{ Form::close() }}

@stop