@section('main')

	<div class="row">

		{{ Former::vertical_open()->method('PATCH')->action(route('admin.projects.update', $model->id))->role('form') }}
			@include('admin.projects._form')
		{{ Former::close() }}

		<div class="col-sm-6">
		@include('admin.files._list', array('files' => $model->files))
		</div>

	</div>

@stop