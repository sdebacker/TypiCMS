@section('head')

	{{ HTML::script(asset('js/list.js')) }}

@stop


@section('header')

	<h1><span id="nb_elements">{{ $models->getTotal() }}</span> {{ trans_choice('global.modules.users', $models->getTotal()) }}</h1>

@stop


@section('buttons')

	<a href="{{ route('admin.users.create') }}" class="btn btn-primary">{{ ucfirst(trans('global.crud.new')) }}</a>

@stop


@section('main')

	<div class="btn-group pull-right">
		@foreach (Config::get('app.locales') as $locale)
			<a class="btn btn-default btn-sm @if($locale == Session::get('locale')) active @endif" href="?locale={{ $locale }}">{{ $locale }}</a>
		@endforeach
	</div>

	<div class="list-form" lang="{{ Config::get('app.locale') }}">

		<div class="btn-toolbar"></div>

		{{ $list }}

	</div>

@stop