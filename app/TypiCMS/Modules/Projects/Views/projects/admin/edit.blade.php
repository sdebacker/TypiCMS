@section('main')

	<div class="row">

		{{ Former::vertical_open()->method('PATCH')->action(route('admin.projects.update', $model->id))->role('form')->class('col-sm-6') }}
			@include('projects.admin._form')
		{{ Former::close() }}

		<div class="col-sm-6">
		@include('files.admin._list', array('files' => $model->files))
		</div>

	</div>

@stop