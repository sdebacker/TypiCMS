<?php

// Groups

Breadcrumbs::register('admin.groups.index', function ($breadcrumbs) {
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push(Str::title(trans('groups::global.name')), route('admin.groups.index'));
});

Breadcrumbs::register('admin.groups.edit', function ($breadcrumbs, $group_id) {
    $group = Sentry::findGroupById($group_id);
    $breadcrumbs->parent('admin.groups.index');
    $breadcrumbs->push($group->name, route('admin.groups.edit', $group_id));
});

Breadcrumbs::register('admin.groups.create', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.groups.index');
    $breadcrumbs->push(trans('groups::global.New'), route('admin.groups.create'));
});
