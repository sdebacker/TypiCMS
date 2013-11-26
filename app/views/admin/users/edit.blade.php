@section('header')

	<h1>Edit @choice('global.modules.users', 1)</h1>

@stop


@section('main')

	{{ Former::vertical_open()->method('PATCH')->action('admin/users/'.$user->id)->role('form') }}
		@include('admin.users._form')
	{{ Former::close() }}

@stop