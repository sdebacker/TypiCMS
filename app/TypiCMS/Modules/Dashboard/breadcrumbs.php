<?php

// Dashboard

Breadcrumbs::register('dashboard', function ($breadcrumbs) {
    $breadcrumbs->push(trans('dashboard::global.name'), route('dashboard'));
});
