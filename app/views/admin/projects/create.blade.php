@section('header')

	<h1>New @choice('global.modules.projects', 1)</h1>

@stop


@section('main')

	{{ Former::vertical_open()->method('POST')->action(route('admin.projects.index'))->role('form') }}
		@include('admin.projects._form')
	{{ Former::close() }}

@stop