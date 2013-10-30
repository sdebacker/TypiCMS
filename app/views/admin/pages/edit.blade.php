@section('header')

	<h1>Edit {{ trans_choice('global.modules.'.$model->view, 1) }}</h1>

@stop


@section('main')

	{{ Former::vertical_open()->method('PATCH')->action(route('admin.pages.update', $model->id))->role('form') }}

		@include('admin.'.$model->view.'._form')

	{{ Former::close() }}

@stop