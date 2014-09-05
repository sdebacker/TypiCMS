<?php

// Translations

Breadcrumbs::register('admin.translations.index', function (\DaveJamesMiller\Breadcrumbs\Generator $breadcrumbs) {
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push(Str::title(trans('translations::global.name')), route('admin.translations.index'));
});

Breadcrumbs::register('admin.translations.edit', function (
        \DaveJamesMiller\Breadcrumbs\Generator $breadcrumbs,
        \TypiCMS\Modules\Translations\Models\Translation $translation
    ) {
    $breadcrumbs->parent('admin.translations.index');
    $breadcrumbs->push($translation->key, route('admin.translations.edit', $translation->id));
});

Breadcrumbs::register('admin.translations.create', function (\DaveJamesMiller\Breadcrumbs\Generator $breadcrumbs) {
    $breadcrumbs->parent('admin.translations.index');
    $breadcrumbs->push(trans('translations::global.New'), route('admin.translations.create'));
});
