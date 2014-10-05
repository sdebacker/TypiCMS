<div class="col-xs-6 col-sm-3 col-md-2 sidebar sidebar-offcanvas" id="sidebar" role="navigation">
    <?php foreach($items->sortBy('weight') as $item): ?>
        <div class="sidebar-panel">
        <?php if (is_object($item)): ?>
            <a class="sidebar-title @if(Config::get('current_user.menus_'.strtolower($item[0]['title']).'_collapsed'))collapsed @endif" href="#{{ strtolower($item[0]['title']) }}" data-toggle="collapse">
                @if ($item[0]['icon-class'])
                <span class="{{ $item[0]['icon-class'] }}"></span>
                @endif
                <div> @lang(strtolower($item[0]['title']) . '::global.name')</div>
            </a>
            <?php $item->shift(); ?>
            <div class="panel-collapse collapse @if(! Config::get('current_user.menus_'.strtolower($item[0]['title']).'_collapsed'))in @endif" id="{{ strtolower($item[0]['title']) }}">
                <ul class="nav nav-sidebar">
                    <?php foreach($item as $subItem): ?>
                        <li class="{{ Request::is($subItem['request']) ? 'active' : ''}}">
                            <a href="{{ URL::route($subItem['route']) }}">
                                <span class="{{ $subItem['icon-class'] }}"></span>
                                <div>{{ $subItem['title'] }}</div>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php else: ?>
            <ul class="nav nav-sidebar">
                <li class="{{ Request::is($item['request']) ? 'active' : ''}}">
                    <a href="{{ URL::route($item['route']) }}">
                        <span class="{{ $item['icon-class'] }}"></span>
                        <div> @lang(strtolower($item['title']) . '::global.name')</div>
                    </a>
                </li>
            </ul>
        <?php endif; ?>
        </div>
    <?php endforeach; ?>

    @include('admin._sidebar-menu', ['name' => 'applications'])
    @include('admin._sidebar-menu', ['name' => 'content'])
    @include('admin._sidebar-menu', ['name' => 'media'])
    @include('admin._sidebar-menu', ['name' => 'system'])
    @include('admin._sidebar-menu', ['name' => 'users'])
</div>
