@section('header')

	<h1>New {{ trans_choice('global.modules.projects', 1) }}</h1>

@stop


@section('main')

	{{ Former::vertical_open()->method('POST')->action(route('admin.categories.projects.index', $category->id))->role('form') }}

		@include('admin.projects._form')

	{{ Former::close() }}

@stop