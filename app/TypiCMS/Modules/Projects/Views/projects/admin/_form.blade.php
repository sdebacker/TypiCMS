@section('head')

	{{ HTML::script(asset('//tinymce.cachefly.net/4.0/tinymce.min.js')) }}
	{{ HTML::script(asset('js/form.js')) }}

@stop

<div class="row">

	@include('admin._buttons-form')

	{{ Form::hidden('id'); }}

	<div class="col-sm-12">

		{{ Former::text('category_id'); }}

		@include('admin._tabs-lang')

		<div class="tab-content">

			@foreach ($locales as $lang)

			<div class="tab-pane fade @if ($locale == $lang)in active@endif" id="{{ $lang }}">
				{{ Former::lg_text($lang.'[title]')->label('title'); }}
				{{ Former::text($lang.'[slug]')->label('slug'); }}
				{{ Former::checkbox($lang.'[status]')->text('Online')->label(''); }}
			</div>

			@endforeach

		</div>

	</div>

</div>