@section('head')
	{{ HTML::script(asset('js/list.js')) }}
@stop

@section('h1')
	<span id="nb_elements">{{ count($models) }}</span> @choice('projects::global.projects', count($models))
@stop

@section('addButton')
	<a href="{{ route('admin.projects.create') }}" class=""><i class="fa fa-plus-circle"></i><span class="sr-only">{{ ucfirst(trans('projects::global.New')) }}</span></a>
@stop


@section('main')

	<div class="list-form" lang="{{ Config::get('app.locale') }}">

		@include('admin._buttons-list')

		<ul class="list-main nested sortable">
		@foreach ($models as $model)
			<li id="item_{{ $model->id }}">
				<div>
					{{ $model->checkbox }}
					{{ $model->status }}
					<a href="{{ route('admin.projects.edit', $model->id) }}">{{ $model->title }}</a>
					<div class="attachments">{{ $model->countFiles }}</div>
				</div>
			</li>
		@endforeach
		</ul>

	</div>

@stop