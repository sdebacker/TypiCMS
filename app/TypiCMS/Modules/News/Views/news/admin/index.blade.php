@section('head')
	{{ HTML::script(asset('js/list.js')) }}
@stop

@section('h1')
	<span id="nb_elements">{{ count($models) }}</span> @choice('modules.news.news', count($models))
@stop

@section('addButton')
	<a href="{{ route('admin.news.create') }}" class=""><span class="glyphicon glyphicon glyphicon-plus-sign"></span><span class="sr-only">{{ ucfirst(trans('modules.news.New')) }}</span></a>&nbsp;
@stop


@section('main')

	<div class="list-form" lang="{{ Config::get('app.locale') }}">

		@include('admin._buttons-list')

		@if(count($models))
			<ul class="list-main">
			@foreach ($models as $model)
				<li id="item_{{ $model->id }}" class="@if($model->status) online @else offline @endif">
					<div>
						<input type="checkbox" value="{{ $model->id }}">
						<span class="switch" style="cursor: pointer;">@lang('global.En ligne/Hors ligne')</span>
						<a href="{{ route('admin.news.edit', $model->id) }}">{{ $model->date }} {{ $model->title }}</a>
					</div>
					<div class="attachments">
						<a class="@if( ! count($model->files))text-muted@endif" href="{{ route('admin.news.files.index', $model->id) }}">{{ count($model->files) }} @choice('modules.files.files', count($model->files))</a>
					</div>
				</li>
			@endforeach
			</ul>
		@endif
		
	</div>

@stop