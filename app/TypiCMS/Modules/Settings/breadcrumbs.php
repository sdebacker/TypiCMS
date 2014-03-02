<?php

// Events

Breadcrumbs::register('admin.settings.index', function($breadcrumbs) {
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push(Str::title(trans_choice('settings::global.settings', 1)), route('admin.settings.index'));
});
