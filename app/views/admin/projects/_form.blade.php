@section('head')

	{{ HTML::script(asset('//tinymce.cachefly.net/4.0/tinymce.min.js')) }}
	{{ HTML::script(asset('js/form.js')) }}

@stop

<div class="row">

	<div class="col-sm-6">

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
				{{ Former::lg_text($lang.'[slug]')->label('slug'); }}
				{{ Former::checkbox($lang.'[status]')->text('Online')->label(''); }}
			</div>

			@endforeach

		</div>

	</div>

</div>

<div>
	{{ Former::text('category_id'); }}
	{{ Former::hidden('id'); }}
	{{ Former::primary_button()->type('submit')->value('Sauver') }}
	{{ Former::link()->class('btn btn-default')->href(route('admin.projects.index'))->value('Annuler') }}
</div>
