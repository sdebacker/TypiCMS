<?php

// Contacts

Breadcrumbs::register('admin.contacts.index', function (\DaveJamesMiller\Breadcrumbs\Generator $breadcrumbs) {
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push(Str::title(trans('contacts::global.name')), route('admin.contacts.index'));
});

Breadcrumbs::register('admin.contacts.edit', function (
        \DaveJamesMiller\Breadcrumbs\Generator $breadcrumbs,
        \TypiCMS\Modules\Contacts\Models\Contact $contact
    ) {
    $breadcrumbs->parent('admin.contacts.index');
    $breadcrumbs->push($contact->first_name . ' ' . $contact->last_name, route('admin.contacts.edit', $contact->id));
});

Breadcrumbs::register('admin.contacts.create', function (\DaveJamesMiller\Breadcrumbs\Generator $breadcrumbs) {
    $breadcrumbs->parent('admin.contacts.index');
    $breadcrumbs->push(trans('contacts::global.New'), route('admin.contacts.create'));
});
