@section('head')
	{{ HTML::script(asset('js/list.js')) }}
@stop

@section('h1')
	<span id="nb_elements">{{ $models->getTotal() }}</span> @choice('news::global.news', $models->getTotal())
@stop

@section('addButton')
	<a href="{{ route('admin.news.create') }}" class=""><i class="fa fa-plus-circle"></i><span class="sr-only">{{ ucfirst(trans('news::global.New')) }}</span></a>
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
						<th>{{ Html::th('status', false) }}</th>
						<th>{{ Html::th('date') }}</th>
						<th>{{ Html::th('title', false) }}</th>
					</tr>

				</thead>

				<tbody>

					@foreach ($models as $model)

					<tr id="item_{{ $model->id }}">
						<td>{{ $model->checkbox }}</td>
						<td>{{ $model->edit }}</td>
						<td>{{ $model->status }}</td>
						<td>{{ $model->date }}</td>
						<td>{{ $model->title }}</td>
					</tr>

					@endforeach

				</tbody>

			</table>

		</div>
		
	</div>

	{{ $models->appends(Input::except('page'))->links() }}

@stop