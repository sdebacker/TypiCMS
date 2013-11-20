@section('head')

	{{ HTML::script(asset('js/form.js')) }}

@stop

	{{ Former::text('webmasterEmail'); }}
	{{ Former::text('typekitCode'); }}
	{{ Former::text('googleAnalyticsCode'); }}
	{{ Former::checkbox('langChooser')->label('')->text('langChooser'); }}

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
				{{ Former::lg_text($lang.'[websiteTitle]')->label('title'); }}
				{{ Former::checkbox($lang.'[status]')->text('Online')->label(''); }}
			</div>

			@endforeach

		</div>


<div>
	{{ Former::primary_button()->type('submit')->value('save') }}
	{{ Former::link()->class('btn btn-default')->href(route('admin.settings.index'))->value('Annuler') }}
</div>
