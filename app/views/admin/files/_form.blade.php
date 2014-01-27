@section('head')

	{{ HTML::script(asset('js/form.js')) }}

@stop

<div class="row">

	@include('admin._buttons')

	{{ Former::hidden('id'); }}

	<div class="col-sm-6">

		@include('admin._langTabs')

		<div class="tab-content">

			@foreach ($locales as $lang)

			<div class="tab-pane fade @if ($locale == $lang)in active@endif" id="{{ $lang }}">
				{{ Former::text($lang.'[alt_attribute]')->label('alt_attribute'); }}
				{{ Former::textarea($lang.'[description]')->label('description'); }}
				{{ Former::text($lang.'[keywords]')->label('keywords'); }}
				{{ Former::checkbox($lang.'[status]')->text('Online')->label(''); }}
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
