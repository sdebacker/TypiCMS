<?php

// Galleries

Breadcrumbs::register('admin.galleries.index', function ($breadcrumbs) {
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push(Str::title(trans('galleries::global.name')), route('admin.galleries.index'));
});

Breadcrumbs::register('admin.galleries.edit', function ($breadcrumbs, $gallery) {
    $breadcrumbs->parent('admin.galleries.index');
    $breadcrumbs->push($gallery->title, route('admin.galleries.edit', $gallery->id));
});

Breadcrumbs::register('admin.galleries.create', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.galleries.index');
    $breadcrumbs->push(trans('galleries::global.New'), route('admin.galleries.create'));
});
