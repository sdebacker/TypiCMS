@section('breadcrumbs') @stop

@section('main')

<div class="row">

	<div class="col-sm-4">

		<div class="panel panel-default">

			<div class="panel-heading">
				<h2 class="panel-title">@lang('modules.dashboard.Welcome, :name!', array('name' => Sentry::getUser()->first_name))</h2>
			</div>

			<div class="panel-body">
				{{ $welcomeMessage }}
			</div>

		</div>

	</div>

	<div class="col-sm-4">

		<div class="panel panel-default">

			<div class="panel-heading">
				<h2 class="panel-title">@lang('modules.dashboard.Modules')</h2>
			</div>

			<div class="list-group">
				@foreach ($modules as $module)
				<a href="{{ URL::route('admin.'.$module['route'].'.index') }}" class="list-group-item"><span class="badge">{{ $module['count'] }}</span> {{ $module['title'] }}</a>
				@endforeach
			</div>

		</div>

	</div>


	@if (Sentry::getUser()->hasAccess(array('admin.menus.index', 'admin.menulinks.index')))

	<div class="col-sm-4">

		<div class="panel panel-default">

			<div class="panel-heading">
				<h2 class="panel-title">@lang('modules.dashboard.Menus')</h2>
			</div>

			<div class="list-group">
				@foreach ($menus as $menu)
				<a href="{{ URL::route('admin.menus.menulinks.index', $menu->id) }}" class="list-group-item">{{ $menu->title }}</a>
				@endforeach
			</div>

		</div>

	</div>

	@endif


</div>

@stop