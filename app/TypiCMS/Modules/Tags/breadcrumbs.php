<?php

// Tags

Breadcrumbs::register('admin.tags.index', function (\DaveJamesMiller\Breadcrumbs\Generator $breadcrumbs) {
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push(Str::title(trans('tags::global.name')), route('admin.tags.index'));
});

Breadcrumbs::register('admin.tags.edit', function (
        \DaveJamesMiller\Breadcrumbs\Generator $breadcrumbs,
        \TypiCMS\Modules\Tags\Models\Tag $tag
    ) {
    $breadcrumbs->parent('admin.tags.index');
    $breadcrumbs->push($tag->title, route('admin.tags.edit', $tag->id));
});

Breadcrumbs::register('admin.tags.create', function (\DaveJamesMiller\Breadcrumbs\Generator $breadcrumbs) {
    $breadcrumbs->parent('admin.tags.index');
    $breadcrumbs->push(trans('tags::global.New'), route('admin.tags.create'));
});
