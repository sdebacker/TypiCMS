<?php

// Partners breadcrumbs

Breadcrumbs::register('admin.partners.index', function ($breadcrumbs) {
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push(Str::title(trans('partners::global.name')), route('admin.partners.index'));
});

Breadcrumbs::register('admin.partners.edit', function ($breadcrumbs, $partner) {
    $breadcrumbs->parent('admin.partners.index');
    $breadcrumbs->push($partner->title, route('admin.partners.edit', $partner->id));
});

Breadcrumbs::register('admin.partners.create', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.partners.index');
    $breadcrumbs->push(trans('partners::global.New'), route('admin.partners.create'));
});
