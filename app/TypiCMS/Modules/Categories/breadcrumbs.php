<?php

// Categories

Breadcrumbs::register('admin.categories.index', function (\DaveJamesMiller\Breadcrumbs\Generator $breadcrumbs) {
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push(Str::title(trans('categories::global.name')), route('admin.categories.index'));
});

Breadcrumbs::register('admin.categories.edit', function (
        \DaveJamesMiller\Breadcrumbs\Generator $breadcrumbs,
        \TypiCMS\Modules\Categories\Models\Category $project
    ) {
    $breadcrumbs->parent('admin.categories.index');
    $breadcrumbs->push($project->title, route('admin.categories.edit', $project->id));
});

Breadcrumbs::register('admin.categories.create', function (\DaveJamesMiller\Breadcrumbs\Generator $breadcrumbs) {
    $breadcrumbs->parent('admin.categories.index');
    $breadcrumbs->push(trans('categories::global.New'), route('admin.categories.create'));
});
