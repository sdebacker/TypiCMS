@section('js')
	{{ HTML::script(asset('//tinymce.cachefly.net/4.0/tinymce.min.js')) }}
	{{ HTML::script(asset('js/form.js')) }}
@stop

<div class="row">

	<div class="col-sm-6">

		<div class="row">
			<div class="col-xs-8">
				{{ Former::text('date')->placeholder('DDMMYYYY')->class('form-control datepicker')->append('<span class="glyphicon glyphicon-calendar"></span>'); }}
			</div>
			<div class="col-xs-4">
				{{ Former::text('time')->placeholder('HH:MM')->class('form-control hourpicker')->append('<span class="glyphicon glyphicon-time"></span>'); }}
			</div>
		</div>

		@if (count($locales) > 1)
		<ul class="nav nav-pills">
			@foreach ($locales as $lang)
			<li class="@if ($locale == $lang)active@endif">
				<a href="#{{ $lang }}" data-target="#{{ $lang }}" data-toggle="tab">{{ $lang }}</a>
			</li>
			@endforeach
		</ul>
		@endif

		<div class="tab-content">

			@foreach ($locales as $lang)

			<div class="tab-pane @if ($locale == $lang)active@endif" id="{{ $lang }}">
				{{ Former::lg_text($lang.'[title]')->label('title'); }}
				{{ Former::text($lang.'[slug]')->label('slug'); }}
				{{ Former::checkbox($lang.'[status]')->text('Online')->label(''); }}
				{{ Former::textarea($lang.'[summary]')->label('summary'); }}
				{{ Former::textarea($lang.'[body]')->label('body')->class('form-control editor'); }}
			</div>

			@endforeach

		</div>

	</div>

</div>

<div>
	{{ Former::hidden('id'); }}
	{{ Former::primary_button()->type('submit')->value('Sauver') }}
	{{ Former::link()->class('btn btn-default')->href(route('admin.news.index'))->value('Annuler') }}
</div>
