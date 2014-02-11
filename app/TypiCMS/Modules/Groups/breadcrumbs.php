<?php

// Groups

Breadcrumbs::register('admin.groups.index', function($breadcrumbs) {
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push(Str::title(trans_choice('modules.groups.groups', 2)), route('admin.groups.index'));
});

Breadcrumbs::register('admin.groups.edit', function($breadcrumbs, $group_id) {
	$group = Sentry::findGroupById($group_id);
    $breadcrumbs->parent('admin.groups.index');
    $breadcrumbs->push($group->name, route('admin.groups.edit', $group_id));
});

Breadcrumbs::register('admin.groups.create', function($breadcrumbs) {
    $breadcrumbs->parent('admin.groups.index');
    $breadcrumbs->push(trans('modules.groups.New'), route('admin.groups.create'));
});
