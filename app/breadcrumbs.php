<?php

// Admin home
Breadcrumbs::register('dashboard', function($breadcrumbs) {
    $breadcrumbs->push(trans('global.Home'), route('dashboard'));
});

// pages
Breadcrumbs::register('admin.pages.index', function($breadcrumbs) {
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push(Str::title(trans_choice('modules.pages.pages', 2)), route('admin.pages.index'));
});

Breadcrumbs::register('admin.pages.edit', function($breadcrumbs, $page) {
    $breadcrumbs->parent('admin.pages.index');
    $breadcrumbs->push($page->title, route('admin.pages.edit', $page->id));
});

Breadcrumbs::register('admin.pages.create', function($breadcrumbs) {
    $breadcrumbs->parent('admin.pages.index');
    $breadcrumbs->push(trans('modules.pages.New'), route('admin.pages.create'));
});

// files linked to modules
$modulesWithFiles = array('pages', 'events', 'news', 'projects');

foreach ($modulesWithFiles as $module) {

    Breadcrumbs::register('admin.' . $module . '.files.index', function($breadcrumbs, $model) use ($module) {
        $breadcrumbs->parent('admin.' . $module . '.edit', $model);
        $breadcrumbs->push(Str::title(trans_choice('modules.files.files', 2)), route('admin.' . $module . '.files.index', $model->id));
    });

    Breadcrumbs::register('admin.' . $module . '.files.edit', function($breadcrumbs, $model, $file) use ($module) {
        $breadcrumbs->parent('admin.' . $module . '.files.index', $model);
        $breadcrumbs->push($file->filename, route('admin.' . $module . '.index'));
    });

    Breadcrumbs::register('admin.' . $module . '.files.create', function($breadcrumbs, $model) use ($module) {
        $breadcrumbs->parent('admin.' . $module . '.files.index', $model);
        $breadcrumbs->push(trans('modules.files.New'), route('admin.' . $module . '.index'));
    });

}


// files
Breadcrumbs::register('admin.files.index', function($breadcrumbs) {
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push(Str::title(trans_choice('modules.files.files', 2)), route('admin.files.index'));
});

Breadcrumbs::register('admin.files.edit', function($breadcrumbs, $file) {
    $breadcrumbs->parent('admin.files.index');
    $breadcrumbs->push($file->filename, route('admin.files.edit', $file->id));
});

Breadcrumbs::register('admin.files.create', function($breadcrumbs) {
    $breadcrumbs->parent('admin.files.index');
    $breadcrumbs->push(trans('modules.files.New'), route('admin.files.create'));
});


// events
Breadcrumbs::register('admin.events.index', function($breadcrumbs) {
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push(Str::title(trans_choice('modules.events.events', 2)), route('admin.events.index'));
});

Breadcrumbs::register('admin.events.edit', function($breadcrumbs, $event) {
    $breadcrumbs->parent('admin.events.index');
    $breadcrumbs->push($event->title, route('admin.events.edit', $event->id));
});

Breadcrumbs::register('admin.events.create', function($breadcrumbs) {
    $breadcrumbs->parent('admin.events.index');
    $breadcrumbs->push(trans('modules.events.New'), route('admin.events.create'));
});


// projects
Breadcrumbs::register('admin.projects.index', function($breadcrumbs) {
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push(Str::title(trans_choice('modules.projects.projects', 2)), route('admin.projects.index'));
});

Breadcrumbs::register('admin.projects.edit', function($breadcrumbs, $project) {
    $breadcrumbs->parent('admin.projects.index');
    $breadcrumbs->push($project->title, route('admin.projects.edit', $project->id));
});

Breadcrumbs::register('admin.projects.create', function($breadcrumbs) {
    $breadcrumbs->parent('admin.projects.index');
    $breadcrumbs->push(trans('modules.projects.New'), route('admin.projects.create'));
});


// categories
Breadcrumbs::register('admin.categories.index', function($breadcrumbs) {
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push(Str::title(trans_choice('modules.categories.categories', 2)), route('admin.categories.index'));
});

Breadcrumbs::register('admin.categories.edit', function($breadcrumbs, $project) {
    $breadcrumbs->parent('admin.categories.index');
    $breadcrumbs->push($project->title, route('admin.categories.edit', $project->id));
});

Breadcrumbs::register('admin.categories.create', function($breadcrumbs) {
    $breadcrumbs->parent('admin.categories.index');
    $breadcrumbs->push(trans('modules.categories.New'), route('admin.categories.create'));
});


// users
Breadcrumbs::register('admin.users.index', function($breadcrumbs) {
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push(Str::title(trans_choice('modules.users.users', 2)), route('admin.users.index'));
});

Breadcrumbs::register('admin.users.edit', function($breadcrumbs, $user_id) {
    $breadcrumbs->parent('admin.users.index');
    $breadcrumbs->push('User id : ' . $user_id, route('admin.users.edit', $user_id));
});

Breadcrumbs::register('admin.users.create', function($breadcrumbs) {
    $breadcrumbs->parent('admin.users.index');
    $breadcrumbs->push(trans('modules.users.New'), route('admin.users.create'));
});


// news
Breadcrumbs::register('admin.news.index', function($breadcrumbs) {
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push(Str::title(trans_choice('modules.news.news', 2)), route('admin.news.index'));
});

Breadcrumbs::register('admin.news.edit', function($breadcrumbs, $news) {
    $breadcrumbs->parent('admin.news.index');
    $breadcrumbs->push($news->title, route('admin.news.edit', $news->id));
});

Breadcrumbs::register('admin.news.create', function($breadcrumbs) {
    $breadcrumbs->parent('admin.news.index');
    $breadcrumbs->push(trans('modules.news.New'), route('admin.news.create'));
});


// menus
Breadcrumbs::register('admin.menus.index', function($breadcrumbs) {
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push(Str::title(trans_choice('modules.menus.menus', 2)), route('admin.menus.index'));
});

Breadcrumbs::register('admin.menus.edit', function($breadcrumbs, $menu) {
    $breadcrumbs->parent('admin.menus.index');
    $breadcrumbs->push($menu->title, route('admin.menus.edit', $menu->id));
});

Breadcrumbs::register('admin.menus.create', function($breadcrumbs) {
    $breadcrumbs->parent('admin.menus.index');
    $breadcrumbs->push(trans('modules.menus.New'), route('admin.menus.create'));
});


// menus.menulinks
Breadcrumbs::register('admin.menus.menulinks.index', function($breadcrumbs, $menu) {
    $breadcrumbs->parent('admin.menus.edit', $menu);
    $breadcrumbs->push(Str::title(trans_choice('modules.menulinks.menulinks', 2)), route('admin.menus.menulinks.index', $menu->id));
});

Breadcrumbs::register('admin.menus.menulinks.edit', function($breadcrumbs, $menu, $menulink) {
    $breadcrumbs->parent('admin.menus.menulinks.index', $menu);
    $breadcrumbs->push($menulink->title, route('admin.menus.index'));
});

Breadcrumbs::register('admin.menus.menulinks.create', function($breadcrumbs, $menu) {
    $breadcrumbs->parent('admin.menus.menulinks.index', $menu);
    $breadcrumbs->push(trans('modules.menulinks.New'), route('admin.menus.index'));
});

// Breadcrumbs::register('category', function($breadcrumbs, $category) {
//     $breadcrumbs->parent('blog');

//     foreach ($category->ancestors as $ancestor) {
//         $breadcrumbs->push($ancestor->title, route('category', $ancestor->id));
//     }

//     $breadcrumbs->push($category->title, route('category', $category->id));
// });

