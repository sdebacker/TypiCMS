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

		<ul id="listmain" class="list-main">
		@foreach ($models as $news)
			<li id="item_{{ $news->id }}" class="@if($news->status) online @else offline @endif">
				<div>
					<input type="checkbox" value="{{ $news->id }}">
					<span class="switch" style="cursor: pointer;">@lang('global.En ligne/Hors ligne')</span>
					<a href="{{ route('admin.news.edit', $news->id) }}">{{ $news->date }} {{ $news->title }}</a>
				</div>
				<div class="attachments">
					<a class="@if( ! count($news->files))text-muted@endif" href="{{ route('admin.news.files.index', $news->id) }}">{{ count($news->files) }} @choice('modules.files.files', count($news->files))</a>
				</div>
			</li>
		@endforeach
		</ul>
		
	</div>

@stop