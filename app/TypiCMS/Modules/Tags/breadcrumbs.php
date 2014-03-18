<?php

// Tags

Breadcrumbs::register('admin.tags.index', function ($breadcrumbs) {
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push(Str::title(trans_choice('tags::global.tags', 2)), route('admin.tags.index'));
});

Breadcrumbs::register('admin.tags.edit', function ($breadcrumbs, $page) {
    $breadcrumbs->parent('admin.tags.index');
    $breadcrumbs->push($page->title, route('admin.tags.edit', $page->id));
});

Breadcrumbs::register('admin.tags.create', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.tags.index');
    $breadcrumbs->push(trans('tags::global.New'), route('admin.tags.create'));
});
