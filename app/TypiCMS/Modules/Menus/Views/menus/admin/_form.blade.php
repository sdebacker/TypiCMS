<div class="row">

	@include('admin._buttons-form')
	
	{{ Former::hidden('id'); }}

	<div class="col-sm-6">

		@include('admin._tabs-lang')

		<div class="tab-content">

			@foreach ($locales as $lang)

			<div class="tab-pane fade @if ($locale == $lang)in active@endif" id="{{ $lang }}">
				{{ Former::lg_text($lang.'[title]')->label('title'); }}
				{{ Former::checkbox($lang.'[status]')->text('Online')->label(''); }}
			</div>

			@endforeach

		</div>

		{{ Former::text('name'); }}

	</div>

</div>
