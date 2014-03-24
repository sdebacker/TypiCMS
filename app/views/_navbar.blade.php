    <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="{{ route('dashboard') }}">{{ Config::get('typicms.' . Config::get('typicms.adminLocale') . '.websiteTitle') }}</a>
            </div>
            <div class="collapse navbar-collapse" id="navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    <li>{{ TypiCMS::otherSideLink() }}</li>
                    @if ($modules)
                    <li class="dropdown">
                        <a href="" class="dropdown-toggle" data-toggle="dropdown">Modules <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                        @foreach ($modules as $module => $property)
                            <li><a href="{{ route('admin.'.strtolower($module).'.index') }}">{{ Str::title(trans_choice(strtolower($module) . '::global.' . strtolower($module), 2, array(), null, Config::get('typicms.adminLocale'))) }}</a></li>
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
                                <p>{{ link_to_route('admin.users.edit', ucFirst( trans_choice('users::global.profile', 2, array(), null, Config::get('typicms.adminLocale')) ), Sentry::getUser()->id ) }}</p>
                                @endif
                                <p>{{ link_to_route('logout', ucfirst(trans('users::global.log out', array(), null, Config::get('typicms.adminLocale'))), null, array('class' => 'btn btn-default btn-xs') ) }}</p>
                            </div>
                        </div>
                    </li>
                    @if (Sentry::getUser()->hasAccess('admin.settings.index'))
                        <li><a href="{{ route('admin.settings.index') }}"><i class="fa fa-cog"></i> <span class="sr-only">{{ ucfirst(trans('global.settings', array(), null, Config::get('typicms.adminLocale'))) }}</span></a></li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>
