@section('header')

	<h1>{{ ucfirst(trans('global.modules.configuration')) }}</h1>

@stop


@section('main')

	{{ Former::vertical_open()->method('POST')->role('form') }}

		@include('admin.configuration._form')

	{{ Former::close() }}

@stop