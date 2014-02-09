@section('main')

	{{ Form::model( $model, array( 'route' => array('admin.pages.update', $model->id), 'method' => 'patch' ) ) }}
		@include('pages.admin._form')
	{{ Form::close() }}

@stop