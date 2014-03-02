<?php

// Dashboard

Breadcrumbs::register('dashboard', function($breadcrumbs) {
    $breadcrumbs->push(trans('global.Home'), route('dashboard'));
});
