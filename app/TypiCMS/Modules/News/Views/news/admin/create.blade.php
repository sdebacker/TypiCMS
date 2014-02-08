@section('main')

	<div class="row">

		{{ Former::vertical_open()->method('POST')->action('admin/news/')->role('form')->class('col-sm-6') }}
			@include('news.admin._form')
		{{ Former::close() }}

	</div>

@stop