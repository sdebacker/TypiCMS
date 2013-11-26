@section('header')

	<h1>New @choice('global.modules.categories', 1)</h1>

@stop


@section('main')

	{{ Former::vertical_open()->method('POST')->action('admin/categories/')->role('form') }}
		@include('admin.categories._form')
	{{ Former::close() }}

@stop