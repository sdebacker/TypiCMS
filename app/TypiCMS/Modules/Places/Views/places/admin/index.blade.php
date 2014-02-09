@section('head')
	{{ HTML::script(asset('js/list.js')) }}
@stop

@section('h1')
	<span id="nb_elements">{{ $models->getTotal() }}</span> @choice('modules.places.places', $models->getTotal())
@stop

@section('addButton')
	<a href="{{ route('admin.places.create') }}" class=""><span class="glyphicon glyphicon glyphicon-plus-sign"></span><span class="sr-only">{{ ucfirst(trans('modules.places.New')) }}</span></a>&nbsp;
@stop


@section('main')

	<div class="list-form" lang="{{ Config::get('app.locale') }}">

		@include('admin._buttons-list')

		@if(count($models))
			<ul id="listmain" class="list-main">
			@foreach ($models as $place)
				<li id="item_{{ $place->id }}" class="@if($place->status) online @else offline @endif">
					<div>
						<input type="checkbox" value="{{ $place->id }}">
						<span class="switch" style="cursor: pointer;">@lang('global.En ligne/Hors ligne')</span>
						<a href="{{ route('admin.places.edit', $place->id) }}">{{ $place->title }}</a>
					</div>
				</li>
			@endforeach
			</ul>
		@endif

	</div>

	{{ $models->links() }}

@stop