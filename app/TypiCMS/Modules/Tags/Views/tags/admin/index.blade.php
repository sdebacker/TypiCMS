@section('head')
	{{ HTML::script(asset('js/list.js')) }}
@stop

@section('h1')
	<span id="nb_elements">{{ $models->getTotal() }}</span> @choice('modules.tags.tags', $models->getTotal())
@stop

@section('addButton')
	<!-- <a href="{{ route('admin.tags.create') }}" class=""><i class="fa fa-plus-circle"></i><span class="sr-only">{{ ucfirst(trans('modules.tags.New')) }}</span></a> -->
@stop


@section('main')

	<div class="list-form" lang="{{ Config::get('app.locale') }}">

		<!-- @include('admin._buttons-list') -->

		{{ HTML::adminTable($models, array('checkboxes' => false, 'edit' => false, 'switch' => false, 'sortable' => false, 'files' => false, 'display' => array(array('%s', 'tag'), array('%s', 'count')))) }}

	</div>

	{{ $models->appends(Input::except('page'))->links() }}

@stop