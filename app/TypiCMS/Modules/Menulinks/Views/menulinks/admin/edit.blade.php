@section('main')

	{{ Form::model( $model, array( 'route' => array('admin.menus.menulinks.update', array($model->menu_id, $model->id)), 'method' => 'patch', 'role' => 'form' ) ) }}
		@include('menulinks.admin._form')
	{{ Form::close() }}

@stop