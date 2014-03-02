@section('head')
	{{ HTML::script(asset('js/list.js')) }}
@stop

@section('h1')
	<span id="nb_elements">{{ $models->getTotal() }}</span> @choice('menulinks::global.menulinks', $models->getTotal())
@stop

@section('addButton')
	<a href="{{ route('admin.menus.menulinks.create', $menu->id) }}" class=""><i class="fa fa-plus-circle"></i><span class="sr-only">{{ ucfirst(trans('menulinks::global.New')) }}</span></a>
@stop


@section('main')

	<div class="list-form" lang="{{ Config::get('app.locale') }}">

		@include('admin._buttons-list')

		{{ HTML::adminList($models, array('sortable' => true, 'nested' => true)) }}

	</div>

@stop