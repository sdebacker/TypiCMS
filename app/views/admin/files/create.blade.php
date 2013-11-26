@section('header')

	<h1>New @choice('global.modules.files', 1)</h1>

@stop


@section('main')

	{{ Former::vertical_open()->method('POST')->action('admin/files/')->role('form') }}
		@include('admin.files._form')
	{{ Former::close() }}

@stop