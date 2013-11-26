@section('header')

	<h1>Edit @choice('global.modules.'.$model->view, 1)</h1>
	<div class="btn-group">
<!-- 		<a href="{{ route('admin.'.$model->route.'.edit', array($model->menu_id, 1)); }}" class="btn btn-default btn-sm">Previous</a>
		<a href="{{ route('admin.'.$model->route.'.edit', array($model->menu_id, 2)); }}" class="btn btn-default btn-sm">Next</a>
 -->	</div>

@stop


@section('main')

	{{ Former::vertical_open()->method('PATCH')->action(route('admin.'.$model->route.'.update', array($model->menu_id, $model->id)))->role('form') }}
		@include('admin.'.$model->view.'._form')
	{{ Former::close() }}

@stop