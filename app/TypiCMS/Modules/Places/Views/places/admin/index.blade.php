@section('head')
	{{ HTML::script(asset('js/list.js')) }}
@stop

@section('h1')
	<span id="nb_elements">{{ $models->getTotal() }}</span> @choice('modules.places.places', $models->getTotal())
@stop

@section('addButton')
	<a href="{{ route('admin.places.create') }}" class=""><i class="fa fa-plus-circle"></i><span class="sr-only">{{ ucfirst(trans('modules.places.New')) }}</span></a>
@stop


@section('main')

	<div class="list-form" lang="{{ Config::get('app.locale') }}">

		@include('admin._buttons-list')

		{{ HTML::adminTable($models, array('files' => false, 'display' => array(array('%s', 'title'), array('%s', 'address'), array('<a href="%s" target="_blank">%s</a>', 'website', 'website')))) }}

	</div>

	{{ $models->appends(Input::except('page'))->links() }}

@stop