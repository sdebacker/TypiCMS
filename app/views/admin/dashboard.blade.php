@section('main')

<h1>{{ trans('global.dashboard.Dashboard') }}</h1>

<div class="panel panel-default">

	<div class="panel-heading">{{ trans('global.dashboard.Welcome, :name!', array('name' => Sentry::getUser()->first_name)) }}</div>

	<div class="panel-body">
		{{ $welcomeMessage }}
	</div>

</div>

<div class="row">


	<div class="col-sm-6">

		<div class="panel panel-default">

			<div class="panel-heading">{{ trans('global.dashboard.Modules') }}</div>

			<div class="list-group">
				@foreach ($modules as $module)
				<a href="{{ URL::route('admin.'.$module['route'].'.index') }}" class="list-group-item">{{ $module['title'] }} <span class="badge">{{ $module['count'] }}</span></a>
				@endforeach
			</div>

		</div>

	</div>


	<div class="col-sm-6">

		<div class="panel panel-default">

			<div class="panel-heading">{{ trans('global.dashboard.Menus') }}</div>

			<div class="list-group">
				@foreach ($menus as $menu)
				<a href="{{ URL::route('admin.menus.menulinks.index', $menu->id) }}" class="list-group-item">{{ $menu->title }}</a>
				@endforeach
			</div>

		</div>

	</div>


</div>

@stop