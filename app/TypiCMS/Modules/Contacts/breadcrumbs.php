<?php

// Contacts

Breadcrumbs::register('admin.contacts.index', function ($breadcrumbs) {
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push(Str::title(trans('contacts::global.name')), route('admin.contacts.index'));
});

Breadcrumbs::register('admin.contacts.edit', function ($breadcrumbs, $contact) {
    $breadcrumbs->parent('admin.contacts.index');
    $breadcrumbs->push($contact->first_name . ' ' . $contact->last_name, route('admin.contacts.edit', $contact->id));
});

Breadcrumbs::register('admin.contacts.create', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.contacts.index');
    $breadcrumbs->push(trans('contacts::global.New'), route('admin.contacts.create'));
});
