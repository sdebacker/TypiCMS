<?php

// Galleries

Breadcrumbs::register('admin.galleries.index', function (\DaveJamesMiller\Breadcrumbs\Generator $breadcrumbs) {
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push(Str::title(trans('galleries::global.name')), route('admin.galleries.index'));
});

Breadcrumbs::register('admin.galleries.edit', function (
        \DaveJamesMiller\Breadcrumbs\Generator $breadcrumbs,
        \TypiCMS\Modules\Galleries\Models\Gallery $gallery
    ) {
    $breadcrumbs->parent('admin.galleries.index');
    $breadcrumbs->push($gallery->title, route('admin.galleries.edit', $gallery->id));
});

Breadcrumbs::register('admin.galleries.create', function (\DaveJamesMiller\Breadcrumbs\Generator $breadcrumbs) {
    $breadcrumbs->parent('admin.galleries.index');
    $breadcrumbs->push(trans('galleries::global.New'), route('admin.galleries.create'));
});
