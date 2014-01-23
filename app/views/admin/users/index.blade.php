@section('head')

	{{ HTML::script(asset('js/list.js')) }}

@stop


@section('buttons')

	<a href="{{ route('admin.users.create') }}" class="btn btn-primary">{{ ucfirst(trans('global.crud.new')) }}</a>

@stop


@section('main')

	<div class="list-form" lang="{{ Config::get('app.locale') }}">

		<div class="btn-toolbar"></div>

		{{ $models->getList() }}

	</div>

@stop