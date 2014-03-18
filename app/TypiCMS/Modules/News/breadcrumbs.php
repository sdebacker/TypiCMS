<?php

// News

Breadcrumbs::register('admin.news.index', function ($breadcrumbs) {
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push(Str::title(trans_choice('news::global.news', 2)), route('admin.news.index'));
});

Breadcrumbs::register('admin.news.edit', function ($breadcrumbs, $news) {
    $breadcrumbs->parent('admin.news.index');
    $breadcrumbs->push($news->title, route('admin.news.edit', $news->id));
});

Breadcrumbs::register('admin.news.create', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.news.index');
    $breadcrumbs->push(trans('news::global.New'), route('admin.news.create'));
});
