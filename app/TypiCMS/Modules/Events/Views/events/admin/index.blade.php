@section('head')
	{{ HTML::script(asset('js/list.js')) }}
@stop

@section('h1')
	<span id="nb_elements">{{ count($models) }}</span> @choice('events::global.events', count($models))
@stop

@section('addButton')
	<a href="{{ route('admin.events.create') }}" class=""><i class="fa fa-plus-circle"></i><span class="sr-only">{{ ucfirst(trans('events::global.New')) }}</span></a>
@stop


@section('main')

	<div class="list-form" lang="{{ Config::get('app.locale') }}">

		@include('admin._buttons-list')

		<div class="table-responsive">

			<table class="table table-condensed table-main">

				<thead>

					<tr>
						<th></th>
						<th></th>
						<th>{{ Html::th('status') }}</th>
						<th>{{ Html::th('start_date') }}</th>
						<th>{{ Html::th('end_date') }}</th>
						<th>{{ Html::th('title') }}</th>
					</tr>

				</thead>

				<tbody>

					@foreach ($models as $model)

					<tr id="item_{{ $model->id }}">
						<td>{{ $model->checkbox }}</td>
						<td>{{ $model->edit }}</td>
						<td>{{ $model->status }}</td>
						<td>{{ $model->start_date }}</td>
						<td>{{ $model->end_date }}</td>
						<td>{{ $model->title }}</td>
						<td><a href="{{ $model->website }}" target="_blank">{{ $model->website }}</a></td>
					</tr>

					@endforeach

				</tbody>

			</table>

		</div>

	</div>

@stop