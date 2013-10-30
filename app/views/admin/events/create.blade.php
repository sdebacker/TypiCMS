@section('header')

	<h1>New {{ trans_choice('global.modules.events', 1) }}</h1>

@stop


@section('main')

	{{ Former::vertical_open()->method('POST')->action('admin/events/')->role('form') }}

		@include('admin.events._form')

	{{ Former::close() }}

@stop