<?php

// Places breadcrumbs

Breadcrumbs::register('admin.news.index', function($breadcrumbs) {
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push(Str::title(trans_choice('modules.news.news', 2)), route('admin.news.index'));
});

Breadcrumbs::register('admin.news.edit', function($breadcrumbs, $place) {
    $breadcrumbs->parent('admin.news.index');
    $breadcrumbs->push($place->title, route('admin.news.edit', $place->id));
});

Breadcrumbs::register('admin.news.create', function($breadcrumbs) {
    $breadcrumbs->parent('admin.news.index');
    $breadcrumbs->push(trans('modules.news.New'), route('admin.news.create'));
});
