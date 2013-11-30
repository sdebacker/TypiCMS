@section('header')

	<h1>New @choice('global.modules.news', 1)</h1>

@stop


@section('main')

	<div class="row">

		{{ Former::vertical_open()->method('POST')->action('admin/news/')->role('form')->class('col-sm-6') }}
			@include('admin.news._form')
		{{ Former::close() }}

	</div>

@stop