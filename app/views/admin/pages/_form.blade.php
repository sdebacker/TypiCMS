@section('head')

	{{ HTML::script(asset('//tinymce.cachefly.net/4.0/tinymce.min.js')) }}
	{{ HTML::script(asset('js/form.js')) }}

@stop

<ul class="nav nav-tabs">
	<li class="active"><a href="#content" data-target="#content" data-toggle="tab">{{ ucfirst(trans('global.form.page content')) }}</a></li>
	<li><a href="#meta" data-target="#meta" data-toggle="tab">{{ ucfirst(trans('global.form.meta data')) }}</a></li>
	<li><a href="#options" data-target="#options" data-toggle="tab">{{ ucfirst(trans('global.form.options')) }}</a></li>
</ul>

<div class="tab-content">

	<div class="tab-pane active" id="content">
		
		@if (count($locales) > 1)
		<ul class="nav nav-pills">
			@foreach ($locales as $lang)
			<li class="@if ($contentlocale == $lang)active@endif">
				<a href="#{{ $lang }}" data-target="#{{ $lang }}" data-toggle="tab">{{ $lang }}</a>
			</li>
			@endforeach
		</ul>
		@endif

		<div class="tab-content">

			@foreach ($locales as $lang)

			<div class="tab-pane @if ($contentlocale == $lang)active@endif" id="{{ $lang }}">
				{{ Former::lg_text($lang.'[title]')->label('title')->autofocus(); }}
				{{ Former::text($lang.'[slug]')->label('slug'); }}
				{{ Former::text($lang.'[uri]')->label('uri'); }}
				{{ Former::textarea($lang.'[body]')->label('body')->class('form-control editor'); }}
				{{ Former::checkbox($lang.'[status]')->label('status')->text('Online')->label(''); }}
			</div>

			@endforeach

		</div>

	</div>

	<div class="tab-pane" id="meta">

		<ul class="nav nav-pills">
			@foreach ($locales as $lang)
			<li class="@if ($contentlocale == $lang)active@endif">
				<a href="#meta-{{ $lang }}" data-target="#meta-{{ $lang }}" data-toggle="tab">{{ $lang }}</a>
			</li>
			@endforeach
		</ul>

		<div class="tab-content">

			@foreach ($locales as $lang)

			<div class="tab-pane @if ($contentlocale == $lang)active@endif" id="meta-{{ $lang }}">
				{{ Former::text($lang.'[meta_title]')->label('meta_title'); }}
				{{ Former::text($lang.'[meta_keywords]')->label('meta_keywords'); }}
				{{ Former::text($lang.'[meta_description]')->label('meta_description'); }}
			</div>

			@endforeach

		</div>

	</div>

	<div class="tab-pane" id="options">

		{{ Former::checkbox('rss_enabled')->text('rss_enabled')->label(''); }}
		{{ Former::checkbox('comments_enabled')->text('comments_enabled')->label(''); }}
		{{ Former::checkbox('is_home')->text('is_home')->label(''); }}
		{{ Former::text('template'); }}
		{{ Former::textarea('css')->rows(10); }}
		{{ Former::textarea('js')->rows(10); }}

	</div>

</div>


<div>
	{{ Former::hidden('id'); }}
	{{ Former::primary_button()->type('submit')->value('Sauver') }}
	{{ Former::link()->class('btn btn-default')->href(route('admin.pages.index'))->value('Annuler') }}
</div>

