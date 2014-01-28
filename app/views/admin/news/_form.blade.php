@section('js')
	{{ HTML::script(asset('//tinymce.cachefly.net/4.0/tinymce.min.js')) }}
	{{ HTML::script(asset('js/form.js')) }}
@stop

<div class="row">

	@include('admin._buttons-form')
	
	{{ Former::hidden('id'); }}

	<div class="col-xs-8">
		{{ Former::text('date')->placeholder('DDMMYYYY')->class('form-control datetimepicker')->append('<span class="glyphicon glyphicon-calendar"></span>'); }}
	</div>

</div>

		@include('admin._tabs-lang')

<div class="tab-content">

	@foreach ($locales as $lang)

	<div class="tab-pane fade @if ($locale == $lang)in active@endif" id="{{ $lang }}">
		{{ Former::lg_text($lang.'[title]')->label('title'); }}
		{{ Former::text($lang.'[slug]')->label('slug'); }}
		{{ Former::checkbox($lang.'[status]')->text('Online')->label(''); }}
		{{ Former::textarea($lang.'[summary]')->label('summary'); }}
		{{ Former::textarea($lang.'[body]')->label('body')->class('form-control editor'); }}
	</div>

	@endforeach

</div>
