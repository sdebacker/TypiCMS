<?php

// Dashboard

Breadcrumbs::register('dashboard', function (\DaveJamesMiller\Breadcrumbs\Generator $breadcrumbs) {
    $breadcrumbs->push(trans('dashboard::global.name'), route('dashboard'));
});
