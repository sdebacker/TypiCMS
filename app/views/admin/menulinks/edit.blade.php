@section('main')

	{{ Former::vertical_open()->method('PATCH')->action(route('admin.'.$model->route.'.update', array($model->menu_id, $model->id)))->role('form') }}
		@include('admin.'.$model->view.'._form')
	{{ Former::close() }}

@stop