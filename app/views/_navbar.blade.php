@if (Sentry::getUser())
	<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a href="{{ route('dashboard') }}" class="navbar-brand">TypiCMS <span class="version">1.0.0-alpha1</span></a>
		</div>
		<div class="navbar-collapse collapse navbar-ex1-collapse">
			<ul class="nav navbar-nav navbar-right">
				<li>{{ HTML::linkRoute('admin.settings.index', ucfirst(trans('global.settings'))) }}</li>
				<li>{{ HTML::linkRoute('admin.users.index', Sentry::getUser()->first_name.' '.Sentry::getUser()->last_name ) }}</li>
				<li>{{ HTML::linkRoute('logout', ucfirst(trans('users.log out')) ) }}</li>
				<li>{{ HTML::linkRoute('admin.users.index', ucFirst( trans_choice('global.modules.users', 2) ) ) }}</li>
			</ul>
		</div>
	</nav>
@endif