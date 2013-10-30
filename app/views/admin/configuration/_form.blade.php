@section('head')

	{{ HTML::script(asset('js/form.js')) }}

@stop

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
				{{ Former::lg_text($lang.'[website_title]')->label('title'); }}
				{{ Former::checkbox($lang.'[status]')->text('Online')->label(''); }}
			</div>

			@endforeach

		</div>

	</div>

</div>

<div>
	{{ Former::primary_button()->type('submit')->value('Sauver') }}
	{{ Former::link()->class('btn btn-default')->href(route('admin.configuration.index'))->value('Annuler') }}
</div>
