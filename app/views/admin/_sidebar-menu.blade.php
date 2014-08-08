<div class="sidebar-panel">
    @if ($menu = Menus::getMenu($name))
    <a class="sidebar-title @if(Config::get('current_user.menus_'.$name.'_collapsed'))collapsed @endif" href="#{{ $name }}" data-toggle="collapse">{{ $menu->translate(Config::get('typicms.adminLocale'))->title }}</a>
    <div class="panel-collapse collapse @if(! Config::get('current_user.menus_'.$name.'_collapsed'))in @endif" id="{{ $name }}">
        <ul class="nav nav-sidebar {{ $menu->class }}">
            @foreach ($menu->menulinks as $menulink)
            <li role="menuitem" class="{{ $menulink->class }}">
                <a href="{{ $menulink->uri }}">
                    @if ($menulink->icon_class)
                        <span class="icon {{ $menulink->icon_class }}"></span>
                    @endif
                    <div>
                        {{ $menulink->translate(Config::get('typicms.adminLocale'))->title }}
                    </div>
                </a>
            </li>
            @endforeach
        </ul>
    </div>
    @endif
</div>
