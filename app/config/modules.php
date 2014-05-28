<?php 
/*
|--------------------------------------------------------------------------
| Available modules
|--------------------------------------------------------------------------
*/
return array(
    'Pages' => [
        'menu'      => true,
        'dashboard' => true,
        'model'     => 'TypiCMS\Modules\Pages\Models\Page'
    ],
    'Galleries' => [
        'menu'      => true,
        'dashboard' => true,
        'model'     => 'TypiCMS\Modules\Galleries\Models\Gallery'
    ],
    'Files' => [
        'menu'      => true,
        'dashboard' => true,
        'model'     => 'TypiCMS\Modules\Files\Models\File'
    ],
    'News'  => [
        'menu'      => true,
        'dashboard' => true,
        'model'     => 'TypiCMS\Modules\News\Models\News'
    ],
    'Events' => [
        'menu'      => true,
        'dashboard' => true,
        'model'     => 'TypiCMS\Modules\Events\Models\Event'
    ],
    'Categories' => [
        'menu'      => true,
        'dashboard' => true,
        'model'     => 'TypiCMS\Modules\Categories\Models\Category'
    ],
    'Projects' => [
        'menu'      => true,
        'dashboard' => true,
        'model'     => 'TypiCMS\Modules\Projects\Models\Project'
    ],
    'Places' => [
        'menu'      => true,
        'dashboard' => true,
        'model'     => 'TypiCMS\Modules\Places\Models\Place'
    ],
    'Menus' => [
        'menu'      => true,
        'dashboard' => false,
        'model'     => 'TypiCMS\Modules\Menus\Models\Menu'
    ],
    'Menulinks' => [
        'menu'      => false,
        'dashboard' => false,
        'model'     => 'TypiCMS\Modules\Menulinks\Models\Menulink'
    ],
    'Tags'  => [
        'menu'      => true,
        'dashboard' => true,
        'model'     => 'TypiCMS\Modules\Tags\Models\Tag'
    ],
    'Users' => [
        'menu'      => true,
        'dashboard' => true,
        'model'     => 'TypiCMS\Modules\Users\Models\User'
    ],
    'Groups' => [
        'menu'      => true,
        'dashboard' => true,
        'model'     => 'TypiCMS\Modules\Groups\Models\Group'
    ],
    'Translations' => [
        'menu'      => true,
        'dashboard' => false,
        'model'     => 'TypiCMS\Modules\Translations\Models\Translation'
    ],
    'Contacts' => [
        'menu'      => true,
        'dashboard' => true, 
        'model'     => 'TypiCMS\Modules\Contacts\Models\Contact'
    ],
);
