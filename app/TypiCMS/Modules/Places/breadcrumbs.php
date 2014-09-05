<?php

// Places breadcrumbs

Breadcrumbs::register('admin.places.index', function (\DaveJamesMiller\Breadcrumbs\Generator $breadcrumbs) {
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push(Str::title(trans('places::global.name')), route('admin.places.index'));
});

Breadcrumbs::register('admin.places.edit', function (
        \DaveJamesMiller\Breadcrumbs\Generator $breadcrumbs,
        \TypiCMS\Modules\Places\Models\Place $place
    ) {
    $breadcrumbs->parent('admin.places.index');
    $breadcrumbs->push($place->title, route('admin.places.edit', $place->id));
});

Breadcrumbs::register('admin.places.create', function (\DaveJamesMiller\Breadcrumbs\Generator $breadcrumbs) {
    $breadcrumbs->parent('admin.places.index');
    $breadcrumbs->push(trans('places::global.New'), route('admin.places.create'));
});
