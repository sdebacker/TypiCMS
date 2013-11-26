@section('header')

	<h1>New @choice('global.modules.menulinks', 1)</h1>

@stop


@section('main')

	{{ Former::vertical_open()->method('POST')->action(route('admin.menus.menulinks.index', $menu->id))->role('form') }}
		@include('admin.menulinks._form')
	{{ Former::close() }}

@stop