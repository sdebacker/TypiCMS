<?php

// Events

Breadcrumbs::register('admin.settings.index', function ($breadcrumbs) {
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push(Str::title(trans('settings::global.name')), route('admin.settings.index'));
});
