@section('head')

	{{ HTML::script(asset('js/list.js')) }}

@stop

@section('page-header')

	<div class="page-header">
		<h1>
			<a href="{{ route('admin.places.create') }}"><span class="glyphicon glyphicon glyphicon-plus-sign"></span><span class="sr-only">{{ ucfirst(trans('modules.places.New')) }}</span></a>&nbsp;
			<span id="nb_elements">{{ $collection->getTotal() }}</span> @choice('modules.places.places', $collection->getTotal())
		</h1>
	</div>

@stop


@section('main')

	<div class="list-form" lang="{{ Config::get('app.locale') }}">

		@include('admin._buttons-list')

		{{ $models->getList() }}

	</div>

	@if(isset($collection))
		{{ $collection->links() }}
	@endif

@stop