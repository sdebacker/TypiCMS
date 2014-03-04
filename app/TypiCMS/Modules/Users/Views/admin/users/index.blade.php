@section('head')
	{{ HTML::script(asset('js/list.js')) }}
@stop

@section('h1')
	<span id="nb_elements">{{ count($models) }}</span> @choice('users::global.users', count($models))
@stop

@section('addButton')
	<a href="{{ route('admin.users.create') }}" class=""><i class="fa fa-plus-circle"></i><span class="sr-only">{{ ucfirst(trans('users::global.New')) }}</span></a>
@stop


@section('main')

	<div class="list-form" lang="{{ Config::get('app.locale') }}">

		@section('btn-locales') @stop
		
		@include('admin._buttons-list')

		<div class="table-responsive">

			<table class="table table-condensed table-main">

				<thead>

					<tr>
						<th></th>
						<th></th>
						<th>{{ Html::th('name') }}</th>
						<th>{{ Html::th('email') }}</th>
						<th>{{ Html::th('permissions', false) }}</th>
						<th>{{ Html::th('isSuperUser') }}</th>
						<th>{{ Html::th('isActivated') }}</th>
					</tr>

				</thead>

				<tbody>

					@foreach ($models as $model)

					<tr id="item_{{ $model->id }}">
						<td>{{ $model->checkbox }}</td>
						<td>{{ $model->edit }}</td>
						<td>{{ $model->first_name }} {{ $model->last_name }}</td>
						<td><a href="mailto:{{ $model->email }}">{{ $model->email }}</a></td>
						<td>{{ $model->getMergedPermissions }}</td>
						<td>{{ $model->superuser }}</td>
						<td>{{ $model->activated }}</td>
					</tr>

					@endforeach

				</tbody>

			</table>

		</div>

	</div>

@stop