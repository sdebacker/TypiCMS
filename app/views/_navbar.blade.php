@section('js')

	{{ HTML::script(asset('components/vendor/bootstrap/js/dropdown.js')) }}
	{{ HTML::script(asset('components/vendor/bootstrap/js/collapse.js')) }}
	{{ HTML::script(asset('components/vendor/bootstrap/js/transition.js')) }}

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
					<li>{{ link_to($url['url'], ucfirst(trans('global.'.$url['label']))) }}</li>
					<li class="dropdown">
						<a href="" class="dropdown-toggle" data-toggle="dropdown">Modules <b class="caret"></b></a>
						<ul class="dropdown-menu">
						@foreach (Config::get('app.modules') as $module => $property)
							@if ($property['menu'])
								<li><a href="{{ route('admin.'.strtolower($module).'.index') }}">{{ Str::title(trans_choice('modules.'.strtolower($module.'.'.$module), 2)) }}</a></li>
							@endif
						@endforeach
						</ul>
					</li>
					<li class="dropdown">
						<a href="{{ route('admin.users.index') }}" class="dropdown-toggle" data-toggle="dropdown">{{ Sentry::getUser()->first_name.' '.Sentry::getUser()->last_name }} <b class="caret"></b></a>
						<div class="dropdown-menu dropdown-user">
							<div class="img pull-left">
								<img src="{{ Gravatar::src(Sentry::getUser()->email, 100) }}" class="pull-left">
							</div>
							<div class="info">
								<p>{{ Sentry::getUser()->email }}</p>
								<p>{{ link_to_route('admin.users.edit', ucFirst( trans_choice('modules.users.profile', 2) ), Sentry::getUser()->id ) }}</p>
								<p>{{ link_to_route('logout', ucfirst(trans('modules.users.log out')), null, array('class' => 'btn btn-default btn-xs') ) }}</p>
							</div>
						</div>
					</li>
					<li><a href="{{ route('admin.settings.index') }}"><i class="glyphicon glyphicon-cog"></i> <span class="sr-only">{{ ucfirst(trans('global.settings')) }}</span></a></li>
				</ul>
			</div>
		</div>
	</nav>
