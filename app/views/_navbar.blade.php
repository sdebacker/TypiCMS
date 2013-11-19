	<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse-1">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a href="{{ route('dashboard') }}" class="navbar-brand">TypiCMS <span class="version">1.0.0-alpha1</span></a>
		</div>
		<div class="navbar-collapse collapse" id="navbar-collapse-1">
			<ul class="nav navbar-nav navbar-right">
				<li>{{ link_to($url['url'], ucfirst(trans('global.'.$url['label']))) }}</li>
				<li>{{ link_to_route('admin.settings.index', ucfirst(trans('global.settings'))) }}</li>
				<li class="dropdown">
					<a href="{{ route('admin.users.index') }}" class="dropdown-toggle" data-toggle="dropdown">{{ Sentry::getUser()->first_name.' '.Sentry::getUser()->last_name }} <b class="caret"></b></a>
					<div class="dropdown-menu dropdown-user">
						<div class="img pull-left">
							<img src="{{ Gravatar::src(Sentry::getUser()->email, 100) }}" class="pull-left">
						</div>
						<div class="info">
							<p>{{ Sentry::getUser()->email }}</p>
							<p>{{ link_to_route('admin.users.edit', ucFirst( trans_choice('users.profile', 2) ), Sentry::getUser()->id ) }}</p>
							<p>{{ link_to_route('logout', ucfirst(trans('users.log out')), null, array('class' => 'btn btn-default btn-xs') ) }}</p>
						</div>
					</div>
				</li>
			</ul>
		</div>
	</nav>
