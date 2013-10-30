@section('head')

	{{ HTML::script(asset('js/list.js')) }}

@stop


@section('buttons')

	<a href="{{ route('admin.files.create') }}" class="btn btn-primary">{{ ucfirst(trans('global.crud.new')) }}</a>

	{{ Former::vertical_open_for_files()->route('admin.files.upload')->class('well')->id('uploader') }}
		{{ Former::files('file')->accept('image')->max(2, 'MB')->class('fileInput'); }}
		@foreach (Config::get('app.locales') as $locale)
			{{ Former::hidden($locale.'[alt_attribute]')->value(''); }}
		@endforeach
		{{ Former::actions()->primary_submit('Submit') }}
	{{ Former::close() }}

@stop


@section('header')

	<h1><span id="nb_elements">{{ $models->getTotal() }}</span> {{ trans_choice('global.modules.files', $models->getTotal()) }}</h1>

@stop


@section('main')

	<div class="btn-group pull-right">
		@foreach (Config::get('app.locales') as $locale)
			<a class="btn btn-default btn-sm @if($locale == Session::get('contentlocale')) active @endif" href="?contentlocale={{ $locale }}">{{ $locale }}</a>
		@endforeach
	</div>

	<div class="list-form" lang="{{ Config::get('app.contentlocale') }}">

		<div class="btn-toolbar"></div>

		{{ $list }}

	</div>

	{{-- $models->links() --}}

@stop