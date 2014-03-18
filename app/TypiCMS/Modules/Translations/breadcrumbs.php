<?php

// Translations

Breadcrumbs::register('admin.translations.index', function ($breadcrumbs) {
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push(Str::title(trans_choice('translations::global.translations', 2)), route('admin.translations.index'));
});

Breadcrumbs::register('admin.translations.edit', function ($breadcrumbs, $translation) {
    $breadcrumbs->parent('admin.translations.index');
    $breadcrumbs->push($translation->title, route('admin.translations.edit', $translation->id));
});

Breadcrumbs::register('admin.translations.create', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.translations.index');
    $breadcrumbs->push(trans('translations::global.New'), route('admin.translations.create'));
});
