@section('head')
	{{ HTML::script(asset('js/list.js')) }}
@stop

@section('h1')
	<span id="nb_elements">{{ count($models) }}</span> @choice('modules.users.users', count($models))
@stop

@section('addButton')
	<a href="{{ route('admin.users.create') }}" class=""><i class="fa fa-plus-circle"></i><span class="sr-only">{{ ucfirst(trans('modules.users.New')) }}</span></a>
@stop


@section('main')

	<div class="list-form" lang="{{ Config::get('app.locale') }}">

		@section('btn-locales') @stop
		
		@include('admin._buttons-list')

		{{ HTML::adminList($models, array('display' => array('%s %s — %s — %s — %s', 'first_name', 'last_name', 'email', 'permissions', 'status'), 'switch' => false)) }}

	</div>

@stop