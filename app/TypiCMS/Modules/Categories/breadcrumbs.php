<?php

// Categories

Breadcrumbs::register('admin.categories.index', function($breadcrumbs) {
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push(Str::title(trans_choice('categories::global.categories', 2)), route('admin.categories.index'));
});

Breadcrumbs::register('admin.categories.edit', function($breadcrumbs, $project) {
    $breadcrumbs->parent('admin.categories.index');
    $breadcrumbs->push($project->title, route('admin.categories.edit', $project->id));
});

Breadcrumbs::register('admin.categories.create', function($breadcrumbs) {
    $breadcrumbs->parent('admin.categories.index');
    $breadcrumbs->push(trans('categories::global.New'), route('admin.categories.create'));
});
