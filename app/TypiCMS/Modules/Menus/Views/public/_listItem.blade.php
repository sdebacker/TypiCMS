<!--
Code for manually display a menu in a blade template :

@if ($mainMenu = Menus::getMenu('main'))
<nav class="col-sm-3 col-md-2" role="navigation">
    <ul class="{{ $mainMenu->class }}">
        @foreach($mainMenu->menulinks as $menulink)
            @include('menus.public._listItem', array('menulink' => $menulink))
        @endforeach
    </ul>
</nav>
@endif
-->

<li id="menuitem_{{ $menulink->id }}" class="{{ $menulink->class }}" role="menuitem">
    <a href="{{ $menulink->uri }}" @if($menulink->models) class="dropdown-toggle" data-toggle="dropdown" @endif>
        @if ($menulink->icon_class)
            <span class="{{ $menulink->icon_class }}"></span>
        @endif
        {{ $menulink->title }}
        @if ($menulink->models)
            <span class="caret"></span>
        @endif
    </a>
    @if ($menulink->models)
        <ul class="dropdown-menu">
            @foreach ($menulink->models as $childMenulink)
                @include('menus.public._listItem', array('menulink' => $childMenulink))
            @endforeach
        </ul>
    @endif
</li>
