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
				{{ Former::text($lang.'[alt_attribute]')->label('alt_attribute'); }}
				{{ Former::textarea($lang.'[description]')->label('description'); }}
				{{ Former::text($lang.'[keywords]')->label('keywords'); }}
				{{ Former::text($lang.'[status]')->label('status'); }}
			</div>

			@endforeach

		</div>

	</div>

	<div class="col-sm-6">

		{{ Former::text('folder_id'); }}
		{{ Former::text('user_id'); }}

		<div class="row">
			<div class="col-sm-3">
				{{ Former::text('user_id'); }}
			</div>
			<div class="col-sm-3">
				{{ Former::text('type'); }}
			</div>
			<div class="col-sm-3">
				{{ Former::text('position'); }}
			</div>
			<div class="col-sm-3">
				{{ Former::text('name'); }}
			</div>
		</div>

		<div class="row">
			<div class="col-sm-3">
				{{ Former::text('path'); }}
			</div>
			<div class="col-sm-3">
				{{ Former::text('filename'); }}
			</div>
			<div class="col-sm-3">
				{{ Former::text('extension'); }}
			</div>
			<div class="col-sm-3">
				{{ Former::text('mimetype'); }}
			</div>
		</div>
		<div class="row">
			<div class="col-sm-3">
				{{ Former::text('width'); }}
			</div>
			<div class="col-sm-3">
				{{ Former::text('height'); }}
			</div>
			<div class="col-sm-3">
				{{ Former::text('download_count'); }}
			</div>
		</div>

	</div>

</div>

<div>
	{{ Former::hidden('id'); }}
	{{ Former::primary_button()->type('submit')->value('Sauver') }}
	{{ Former::link()->class('btn btn-default')->href(route('admin.pages.index'))->value('Annuler') }}
</div>
