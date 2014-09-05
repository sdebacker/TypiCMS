<?php

// Menus

Breadcrumbs::register('admin.menus.index', function (\DaveJamesMiller\Breadcrumbs\Generator $breadcrumbs) {
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push(Str::title(trans('menus::global.name')), route('admin.menus.index'));
});

Breadcrumbs::register('admin.menus.edit', function (
        \DaveJamesMiller\Breadcrumbs\Generator $breadcrumbs,
        \TypiCMS\Modules\Menus\Models\Menu $menu
    ) {
    $breadcrumbs->parent('admin.menus.index');
    $breadcrumbs->push($menu->title, route('admin.menus.edit', $menu->id));
});

Breadcrumbs::register('admin.menus.create', function (\DaveJamesMiller\Breadcrumbs\Generator $breadcrumbs) {
    $breadcrumbs->parent('admin.menus.index');
    $breadcrumbs->push(trans('menus::global.New'), route('admin.menus.create'));
});
