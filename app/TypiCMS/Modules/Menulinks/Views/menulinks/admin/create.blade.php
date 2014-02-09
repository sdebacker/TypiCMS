@section('main')

	{{ Former::vertical_open()->method('POST')->action(route('admin.menus.menulinks.index', $menu->id))->role('form') }}
		@include('menulinks.admin._form')
	{{ Former::close() }}

@stop