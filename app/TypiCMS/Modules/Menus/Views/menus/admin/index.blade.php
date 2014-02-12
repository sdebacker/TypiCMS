@section('head')
	{{ HTML::script(asset('js/list.js')) }}
@stop

@section('h1')
	<span id="nb_elements">{{ count($models) }}</span> @choice('modules.menus.menus', count($models))
@stop

@section('addButton')
	<a href="{{ route('admin.menus.create') }}" class=""><i class="fa fa-plus-circle"></i><span class="sr-only">{{ ucfirst(trans('modules.menus.New')) }}</span></a>
@stop


@section('main')

	<div class="list-form" lang="{{ Config::get('app.locale') }}">

		@include('admin._buttons-list')

		{{ HTML::adminList($models, array('display' => array('%s (%s)', 'title', 'name'))) }}

	</div>

@stop