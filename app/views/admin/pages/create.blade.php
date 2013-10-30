@section('header')

	<h1>New {{ trans_choice('global.modules.pages', 1) }}</h1>

@stop


@section('main')

	{{ Former::vertical_open()->method('POST')->action(route('admin.pages.index'))->role('form') }}

		@include('admin.pages._form')

	{{ Former::close() }}

@stop