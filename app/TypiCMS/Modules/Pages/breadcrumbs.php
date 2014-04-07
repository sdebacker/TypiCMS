<?php

// Pages

Breadcrumbs::register('admin.pages.index', function ($breadcrumbs) {
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push(Str::title(trans('pages::global.name')), route('admin.pages.index'));
});

Breadcrumbs::register('admin.pages.edit', function ($breadcrumbs, $page) {
    $breadcrumbs->parent('admin.pages.index');
    $breadcrumbs->push($page->title, route('admin.pages.edit', $page->id));
});

Breadcrumbs::register('admin.pages.create', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.pages.index');
    $breadcrumbs->push(trans('pages::global.New'), route('admin.pages.create'));
});
