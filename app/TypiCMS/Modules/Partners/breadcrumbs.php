<?php

// Partners breadcrumbs

Breadcrumbs::register('admin.partners.index', function (\DaveJamesMiller\Breadcrumbs\Generator $breadcrumbs) {
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push(Str::title(trans('partners::global.name')), route('admin.partners.index'));
});

Breadcrumbs::register('admin.partners.edit', function (
        \DaveJamesMiller\Breadcrumbs\Generator $breadcrumbs,
        \TypiCMS\Modules\Partners\Models\Partner $partner
    ) {
    $breadcrumbs->parent('admin.partners.index');
    $breadcrumbs->push($partner->title, route('admin.partners.edit', $partner->id));
});

Breadcrumbs::register('admin.partners.create', function (\DaveJamesMiller\Breadcrumbs\Generator $breadcrumbs) {
    $breadcrumbs->parent('admin.partners.index');
    $breadcrumbs->push(trans('partners::global.New'), route('admin.partners.create'));
});
