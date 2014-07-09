<div class="sidebar-panel">
    @if ($menu = Menus::getMenu($name))
    <a class="sidebar-title" href="#{{ $name }}-container" data-toggle="collapse">{{ $menu->translate(Config::get('typicms.adminLocale'))->title }}</a>
    <div class="panel-collapse collapse in" id="{{ $name }}-container">
    <ul class="nav nav-sidebar {{ $menu->class }}">
        @foreach ($menu->menulinks as $menulink)
            <li role="menuitem" class="{{ $menulink->class }}">
                <a href="{{ $menulink->uri }}">
                    @if ($menulink->icon_class)
                        <span class="{{ $menulink->icon_class }}"></span> 
                    @endif
                    {{ $menulink->translate(Config::get('typicms.adminLocale'))->title }}
                </a>
            </li>
        @endforeach
    </ul>
    </div>
    @endif
</div>
