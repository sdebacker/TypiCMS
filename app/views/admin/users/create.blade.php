@section('header')

	<h1>New {{ trans_choice('global.modules.users', 1) }}</h1>

@stop


@section('main')

	{{ Former::vertical_open()->method('POST')->action('admin/users/')->role('form') }}

		@include('admin.users._form')

	{{ Former::close() }}

@stop