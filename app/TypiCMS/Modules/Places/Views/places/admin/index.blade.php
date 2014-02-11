@section('head')
	{{ HTML::script(asset('js/list.js')) }}
@stop

@section('h1')
	<span id="nb_elements">{{ count($models) }}</span> @choice('modules.places.places', count($models))
@stop

@section('addButton')
	<a href="{{ route('admin.places.create') }}" class=""><span class="glyphicon glyphicon glyphicon-plus-sign"></span><span class="sr-only">{{ ucfirst(trans('modules.places.New')) }}</span></a>&nbsp;
@stop


@section('main')

	<div class="list-form" lang="{{ Config::get('app.locale') }}">

		@section('btn-locales') @stop

		@include('admin._buttons-list')

		{{ HTML::adminList($models) }}

	</div>

	{{ $models->links() }}

@stop