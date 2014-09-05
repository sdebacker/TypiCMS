<?php

// Blocks breadcrumbs

Breadcrumbs::register('admin.blocks.index', function (\DaveJamesMiller\Breadcrumbs\Generator $breadcrumbs) {
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push(Str::title(trans('blocks::global.name')), route('admin.blocks.index'));
});

Breadcrumbs::register('admin.blocks.edit', function (
        \DaveJamesMiller\Breadcrumbs\Generator $breadcrumbs,
        \TypiCMS\Modules\Blocks\Models\Block $block
    ) {
    $breadcrumbs->parent('admin.blocks.index');
    $breadcrumbs->push($block->name, route('admin.blocks.edit', $block->id));
});

Breadcrumbs::register('admin.blocks.create', function (\DaveJamesMiller\Breadcrumbs\Generator $breadcrumbs) {
    $breadcrumbs->parent('admin.blocks.index');
    $breadcrumbs->push(trans('blocks::global.New'), route('admin.blocks.create'));
});
