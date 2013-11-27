@section('head')

	{{ HTML::script(asset('js/list.js')) }}

@stop

@section('header')

	<h1><span id="nb_elements">{{ $models->getTotal() }}</span> @choice('global.modules.events', $models->getTotal())</h1>

@stop


@section('buttons')

	<a href="{{ route('admin.events.create') }}" class="btn btn-primary">{{ ucfirst(trans('global.crud.new')) }}</a>

@stop


@section('main')

	<div class="list-form" lang="{{ Config::get('app.locale') }}">

		<div class="btn-toolbar"></div>

		{{ $models->getList() }}

	</div>

@stop