@section('header')

	<h1>New {{ trans_choice('global.modules.news', 1) }}</h1>

@stop


@section('main')

	{{ Former::vertical_open()->method('POST')->action('admin/news/')->role('form') }}

		@include('admin.news._form')

	{{ Former::close() }}

@stop