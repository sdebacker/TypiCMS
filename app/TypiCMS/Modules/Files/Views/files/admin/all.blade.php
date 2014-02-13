@section('head')
	{{ HTML::script(asset('js/list.js')) }}
@stop

@section('h1')
	<span id="nb_elements">{{ count($models) }}</span> @choice('modules.files.files', count($models))
@stop

@section('addButton')
	<span class="sr-only">{{ ucfirst(trans('modules.files.New')) }}</span>
@stop

@section('main')

	<div class="alert alert-info">
		@lang('global.files_edit_info').
	</div>

	@include('admin._buttons-list')

	@foreach ($models as $key => $model)
		<span class="thumbnail @if($model->status == 1) online @else offline @endif" id="item_{{ $model->id }}">
			<img src="{{ Croppa::url('/'.$model->path.'/'.$model->filename, 100, 100) }}" alt="{{ $model->alt_attribute }}">
			<div class="caption">
				<div>{{ $model->filename }}</div>
				<div>{{ $model->alt_attribute }}</div>
			</div>
		</span>
	@endforeach

@stop