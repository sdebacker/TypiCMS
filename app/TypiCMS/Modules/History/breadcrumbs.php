<?php

// History

Breadcrumbs::register('admin.history.index', function (\DaveJamesMiller\Breadcrumbs\Generator $breadcrumbs) {
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push(Str::title(trans('history::global.name')), route('admin.history.index'));
});

Breadcrumbs::register('admin.history.edit', function (
        \DaveJamesMiller\Breadcrumbs\Generator $breadcrumbs,
        \TypiCMS\Modules\History\Models\History $history
    ) {
    $breadcrumbs->parent('admin.history.index');
    $breadcrumbs->push($history->title, route('admin.history.edit', $history->id));
});

Breadcrumbs::register('admin.history.create', function (\DaveJamesMiller\Breadcrumbs\Generator $breadcrumbs) {
    $breadcrumbs->parent('admin.history.index');
    $breadcrumbs->push(trans('history::global.New'), route('admin.history.create'));
});
