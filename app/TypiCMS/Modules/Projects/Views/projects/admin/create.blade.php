@section('main')

	<div class="row">

		{{ Former::vertical_open()->method('POST')->action(route('admin.projects.index'))->role('form')->class('col-sm-6') }}
			@include('projects.admin._form')
		{{ Former::close() }}

	</div>

@stop