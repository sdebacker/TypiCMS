@section('main')

	<div class="row">

		{{ Form::model( $model, array( 'route' => array('admin.projects.update', $model->id), 'method' => 'patch', 'role' => 'form' ) ) }}
			@include('projects.admin._form')
		{{ Form::close() }}

		<div class="col-sm-6">
		@include('files.admin._list', array('files' => $model->files))
		</div>

	</div>

@stop