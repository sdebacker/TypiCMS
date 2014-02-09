@section('main')

		{{ Former::vertical_open()->method('PATCH')->action(route('admin.pages.update', $model->id))->role('form') }}
			@include('pages.admin._form')
		{{ Former::close() }}

@stop