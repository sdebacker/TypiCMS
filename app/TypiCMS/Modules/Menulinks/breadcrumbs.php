<?php

// Menulinks

Breadcrumbs::register('admin.menus.menulinks.index', function (
        \DaveJamesMiller\Breadcrumbs\Generator $breadcrumbs,
        \TypiCMS\Modules\Menus\Models\Menu $menu
    ) {
    $breadcrumbs->parent('admin.menus.edit', $menu);
    $breadcrumbs->push(Str::title(trans('menulinks::global.name')), route('admin.menus.menulinks.index', $menu->id));
});

Breadcrumbs::register('admin.menus.menulinks.edit', function (
        \DaveJamesMiller\Breadcrumbs\Generator $breadcrumbs,
        \TypiCMS\Modules\Menus\Models\Menu $menu,
        \TypiCMS\Modules\Menulinks\Models\Menulink $menulink
    ) {
    $breadcrumbs->parent('admin.menus.menulinks.index', $menu);
    $breadcrumbs->push($menulink->title, route('admin.menus.index'));
});

Breadcrumbs::register('admin.menus.menulinks.create', function (
        \DaveJamesMiller\Breadcrumbs\Generator $breadcrumbs,
        \TypiCMS\Modules\Menus\Models\Menu $menu
    ) {
    $breadcrumbs->parent('admin.menus.menulinks.index', $menu);
    $breadcrumbs->push(trans('menulinks::global.New'), route('admin.menus.index'));
});
