@section('head')

	{{ HTML::script(asset('js/list.js')) }}

@stop


@section('buttons')

	<a href="{{ route('admin.files.create') }}" class="btn btn-primary">{{ ucfirst(trans('global.crud.new')) }}</a>

	{{ Former::vertical_open_for_files()->route('admin.files.upload')->class('well dropzone')->id('uploader') }}
		@foreach (Config::get('app.locales') as $locale)
			{{ Former::hidden($locale.'[alt_attribute]')->value(''); }}
		@endforeach
		@if($relatedModel)
		{{ Former::hidden('fileable_id')->value($relatedModel->id); }}
		{{ Former::hidden('fileable_type')->value(get_class($relatedModel)); }}
		@endif
		<div class="fallback">
		{{ Former::file('file')->accept('image')->max(2, 'MB')->class('fileInput'); }}
		{{ Former::actions()->primary_submit('Submit') }}
		</div>
	{{ Former::close() }}

@stop


@section('header')

	<h1><span id="nb_elements">{{ $models->getTotal() }}</span> {{ trans_choice('global.modules.files', $models->getTotal()) }}</h1>

@stop


@section('main')

	<div class="list-form" lang="{{ Config::get('app.locale') }}">

		<div class="btn-toolbar"></div>

		{{ $list }}

	</div>

	{{-- $models->links() --}}

@stop