@section('header')

	<h1>New @choice('global.modules.menus', 1)</h1>

@stop


@section('main')

	{{ Former::vertical_open()->method('POST')->action('admin/menus/')->role('form') }}
		@include('admin.menus._form')
	{{ Former::close() }}

@stop