<?php

// News

Breadcrumbs::register('admin.news.index', function (\DaveJamesMiller\Breadcrumbs\Generator $breadcrumbs) {
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push(Str::title(trans('news::global.name')), route('admin.news.index'));
});

Breadcrumbs::register('admin.news.edit', function (
        \DaveJamesMiller\Breadcrumbs\Generator $breadcrumbs,
        \TypiCMS\Modules\News\Models\News $news
    ) {
    $breadcrumbs->parent('admin.news.index');
    $breadcrumbs->push($news->title, route('admin.news.edit', $news->id));
});

Breadcrumbs::register('admin.news.create', function (\DaveJamesMiller\Breadcrumbs\Generator $breadcrumbs) {
    $breadcrumbs->parent('admin.news.index');
    $breadcrumbs->push(trans('news::global.New'), route('admin.news.create'));
});
