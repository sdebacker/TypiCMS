@section('header')

	<h1>{{ ucfirst(trans('global.modules.settings')) }}</h1>

@stop


@section('main')

	{{ Former::vertical_open()->method('POST')->role('form') }}

		@include('admin.settings._form')

	{{ Former::close() }}

@stop