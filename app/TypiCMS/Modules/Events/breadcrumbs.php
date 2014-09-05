<?php

// Events

Breadcrumbs::register('admin.events.index', function (\DaveJamesMiller\Breadcrumbs\Generator $breadcrumbs) {
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push(Str::title(trans('events::global.name')), route('admin.events.index'));
});

Breadcrumbs::register('admin.events.edit', function (
        \DaveJamesMiller\Breadcrumbs\Generator $breadcrumbs,
        \TypiCMS\Modules\Events\Models\Event $event
    ) {
    $breadcrumbs->parent('admin.events.index');
    $breadcrumbs->push($event->title, route('admin.events.edit', $event->id));
});

Breadcrumbs::register('admin.events.create', function (\DaveJamesMiller\Breadcrumbs\Generator $breadcrumbs) {
    $breadcrumbs->parent('admin.events.index');
    $breadcrumbs->push(trans('events::global.New'), route('admin.events.create'));
});
