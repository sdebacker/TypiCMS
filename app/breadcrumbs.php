<?php

// Admin home
Breadcrumbs::register('dashboard', function($breadcrumbs) {
    $breadcrumbs->push(trans('global.Home'), route('dashboard'));
});
