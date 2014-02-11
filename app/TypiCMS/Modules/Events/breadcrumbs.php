<?php

// Events

Breadcrumbs::register('admin.events.index', function($breadcrumbs) {
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push(Str::title(trans_choice('modules.events.events', 2)), route('admin.events.index'));
});

Breadcrumbs::register('admin.events.edit', function($breadcrumbs, $event) {
    $breadcrumbs->parent('admin.events.index');
    $breadcrumbs->push($event->title, route('admin.events.edit', $event->id));
});

Breadcrumbs::register('admin.events.create', function($breadcrumbs) {
    $breadcrumbs->parent('admin.events.index');
    $breadcrumbs->push(trans('modules.events.New'), route('admin.events.create'));
});
