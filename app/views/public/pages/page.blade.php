@section('head')
	@if($model->css)
	<style type="text/css">
		{{ $model->css }}
	</style>
	@endif
	@if($model->js)
	<script>
		{{ $model->js }}
	</script>
	@endif
@stop

@section('main')

	<h2 class="sr-only">{{ $model->title }}</h2>
	{{ $model->body }}
	{{ trans('public.More') }}

@stop

@section('files')
	<div>
		{{ $files }}
	</div>
@stop