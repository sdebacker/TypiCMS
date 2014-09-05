<?php

// Projects

Breadcrumbs::register('admin.projects.index', function (\DaveJamesMiller\Breadcrumbs\Generator $breadcrumbs) {
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push(Str::title(trans('projects::global.name')), route('admin.projects.index'));
});

Breadcrumbs::register('admin.projects.edit', function (
        \DaveJamesMiller\Breadcrumbs\Generator $breadcrumbs,
        \TypiCMS\Modules\Projects\Models\Project $project
    ) {
    $breadcrumbs->parent('admin.projects.index');
    $breadcrumbs->push($project->title, route('admin.projects.edit', $project->id));
});

Breadcrumbs::register('admin.projects.create', function (\DaveJamesMiller\Breadcrumbs\Generator $breadcrumbs) {
    $breadcrumbs->parent('admin.projects.index');
    $breadcrumbs->push(trans('projects::global.New'), route('admin.projects.create'));
});
