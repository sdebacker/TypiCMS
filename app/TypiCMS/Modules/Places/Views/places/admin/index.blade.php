@section('head')
	{{ HTML::script(asset('js/list.js')) }}
@stop

@section('h1')
	<span id="nb_elements">{{ $models->getTotal() }}</span> @choice('places::global.places', $models->getTotal())
@stop

@section('addButton')
	<a href="{{ route('admin.places.create') }}" class=""><i class="fa fa-plus-circle"></i><span class="sr-only">{{ ucfirst(trans('places::global.New')) }}</span></a>
@stop


@section('main')

	<div class="list-form" lang="{{ Config::get('app.locale') }}">

		@include('admin._buttons-list')

		<div class="table-responsive">

			<table class="table table-condensed table-main">

				<thead>

					<th></th>
					<th></th>
					<th>{{ Html::th('status') }}</th>
					<th>{{ Html::th('title') }}</th>
					<th>{{ Html::th('address') }}</th>
					<th>{{ Html::th('website') }}</th>

				</thead>

				<tbody>

					@foreach ($models as $model)

					<tr id="item_{{ $model->id }}">
						<td>{{ $model->checkbox }}</td>
						<td>{{ $model->edit }}</td>
						<td>{{ $model->status }}</td>
						<td>{{ $model->title }}</td>
						<td>{{ $model->address }}</td>
						<td><a href="{{ $model->website }}" target="_blank">{{ $model->website }}</a></td>
					</tr>

					@endforeach

				</tbody>

			</table>

		</div>

	</div>

	{{ $models->appends(Input::except('page'))->links() }}

@stop