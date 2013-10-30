<div class="row">

	<div class="col-sm-6">

		<ul class="nav nav-tabs">

			@foreach ($locales as $lang)

			<li class="@if ($contentlocale == $lang)active@endif">
				<a href="#{{ $lang }}" data-target="#{{ $lang }}" data-toggle="tab">{{ $lang }}</a>
			</li>

			@endforeach

		</ul>

		<div class="tab-content">

			@foreach ($locales as $lang)

			<div class="tab-pane @if ($contentlocale == $lang)active@endif" id="{{ $lang }}">
				{{ Former::lg_text($lang.'[title]')->label('title'); }}
				{{ Former::checkbox($lang.'[status]')->text('Online')->label(''); }}
			</div>

			@endforeach

		</div>

		{{ Former::text('name'); }}

	</div>

</div>

<div>
	{{ Former::hidden('id'); }}
	{{ Former::primary_button()->type('submit')->value('Sauver') }}
	{{ Former::link()->class('btn btn-default')->href(route('admin.menus.index'))->value('Annuler') }}
</div>
