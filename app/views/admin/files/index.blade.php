@section('head')

	{{ HTML::script(asset('js/list.js')) }}

@stop


@section('main')

	<div class="list-form" lang="{{ Config::get('app.locale') }}">

		<div class="btn-toolbar"></div>

		{{ Former::vertical_open_for_files()->action(route('admin.files.upload'))->class('thumbnail thumbnail-dropzone')->id('uploader') }}
			@foreach (Config::get('app.locales') as $locale)
				{{ Former::hidden($locale.'[alt_attribute]')->value(''); }}
				{{ Former::hidden($locale.'[status]')->value(1); }}
			@endforeach
			@if($relatedModel)
			{{ Former::hidden('fileable_id')->value($relatedModel->id); }}
			{{ Former::hidden('fileable_type')->value(get_class($relatedModel)); }}
			@endif
			<div class="dz-message">@lang('global.Drop files to upload (or click)')</div>
			<div class="fallback">
			{{ Former::file('file')->accept('image')->max(2, 'MB')->class('fileInput'); }}
			{{ Former::actions()->primary_submit('Submit') }}
			</div>
		{{ Former::close() }}

		<div class="dropzone-previews"></div>

		<div class="sortable sortable-thumbnails">
		@foreach ($models as $key => $model)
			<a href="{{ route('admin.files.edit', $model->id) }}" class="thumbnail @if($model->status == 1) online @else offline @endif" id="item_{{ $model->id }}">
				<input type="checkbox" value="{{ $model->id }}">
				<img src="{{ Croppa::url('/'.$model->path.'/'.$model->filename, 100, 100) }}" alt="{{ $model->alt_attribute }}">
				<div class="caption">
					<div>{{ $model->filename }}</div>
					<div>{{ $model->alt_attribute }}</div>
				</div>
			</a>
		@endforeach
		</div>

	</div>

	{{-- $models->links() --}}

@stop