@section('js')

	{{ HTML::script(asset('vendor/bootstrap/js/collapse.js')) }}
	{{ HTML::script(asset('vendor/bootstrap/js/transition.js')) }}

@show

	<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse-1">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="{{ route('dashboard') }}">{{ $title }}</a>
			</div>
			<div class="collapse navbar-collapse" id="navbar-collapse-1">
				<ul class="nav navbar-nav navbar-right">
					@if ($navBarModules)
					<li>{{ link_to($url['url'], ucfirst(trans('global.'.$url['label']))) }}</li>
					<li class="dropdown">
						<a href="" class="dropdown-toggle" data-toggle="dropdown">Modules <b class="caret"></b></a>
						<ul class="dropdown-menu">
						@foreach ($navBarModules as $module => $property)
							<li><a href="{{ route('admin.'.strtolower($module).'.index') }}">{{ Str::title(trans_choice(strtolower($module) . '::global.' . strtolower($module), 2)) }}</a></li>
						@endforeach
						</ul>
					</li>
					@endif
					<li class="dropdown">
						<a href="{{ route('admin.users.index') }}" class="dropdown-toggle" data-toggle="dropdown">{{ Sentry::getUser()->first_name.' '.Sentry::getUser()->last_name }} <b class="caret"></b></a>
						<div class="dropdown-menu dropdown-user">
							<div class="img pull-left">
								<img src="{{ Gravatar::src(Sentry::getUser()->email, 100) }}" class="pull-left">
							</div>
							<div class="info">
								<p>{{ Sentry::getUser()->email }}</p>
								@if (Sentry::getUser()->hasAccess('admin.users.edit'))
								<p>{{ link_to_route('admin.users.edit', ucFirst( trans_choice('users::global.profile', 2) ), Sentry::getUser()->id ) }}</p>
								@endif
								<p>{{ link_to_route('logout', ucfirst(trans('users::global.log out')), null, array('class' => 'btn btn-default btn-xs') ) }}</p>
							</div>
						</div>
					</li>
					@if (Sentry::getUser()->hasAccess('admin.settings.index'))
						<li><a href="{{ route('admin.settings.index') }}"><i class="fa fa-cog"></i> <span class="sr-only">{{ ucfirst(trans('global.settings')) }}</span></a></li>
					@endif
				</ul>
			</div>
		</div>
	</nav>
