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

	<h1>{{ $model->title }}</h1>
	{{ $model->body }}
	{{ trans('public.More') }}

@stop

