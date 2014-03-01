<?php

// Events

Breadcrumbs::register('admin.events.index', function($breadcrumbs) {
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push(Str::title(trans_choice('events::global.events', 2)), route('admin.events.index'));
});

Breadcrumbs::register('admin.events.edit', function($breadcrumbs, $event) {
    $breadcrumbs->parent('admin.events.index');
    $breadcrumbs->push($event->title, route('admin.events.edit', $event->id));
});

Breadcrumbs::register('admin.events.create', function($breadcrumbs) {
    $breadcrumbs->parent('admin.events.index');
    $breadcrumbs->push(trans('events::global.New'), route('admin.events.create'));
});
