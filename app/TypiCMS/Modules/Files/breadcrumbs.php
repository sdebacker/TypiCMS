<?php

// Files

Breadcrumbs::register('admin.files.index', function (\DaveJamesMiller\Breadcrumbs\Generator $breadcrumbs) {
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push(Str::title(trans('files::global.name')), route('admin.files.index'));
});

// Files linked to modules
$modulesWithFiles = array('pages', 'events', 'news', 'projects');

foreach ($modulesWithFiles as $module) {

    Breadcrumbs::register('admin.' . $module . '.files.index', function (
            \DaveJamesMiller\Breadcrumbs\Generator $breadcrumbs,
            \TypiCMS\Modules\Files\Models\File $model
        ) use ($module) {
        $breadcrumbs->parent('admin.' . $module . '.edit', $model);
        $breadcrumbs->push(
            Str::title(trans_choice('files::global.files', 2)),
            route('admin.' . $module . '.files.index', $model->id)
        );
    });

    Breadcrumbs::register('admin.' . $module . '.files.edit', function (
            \DaveJamesMiller\Breadcrumbs\Generator $breadcrumbs,
            $model,
            \TypiCMS\Modules\Files\Models\File $file
        ) use ($module) {
        $breadcrumbs->parent('admin.' . $module . '.files.index', $model);
        $breadcrumbs->push($file->filename, route('admin.' . $module . '.index'));
    });

    Breadcrumbs::register('admin.' . $module . '.files.create', function (\DaveJamesMiller\Breadcrumbs\Generator $breadcrumbs, $model) use ($module) {
        $breadcrumbs->parent('admin.' . $module . '.files.index', $model);
        $breadcrumbs->push(trans('files::global.New'), route('admin.' . $module . '.index'));
    });

}
