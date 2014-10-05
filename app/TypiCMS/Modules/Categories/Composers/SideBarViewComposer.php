<?php
namespace TypiCMS\Modules\Categories\Composers;

use Illuminate\Support\Facades\Config;

class SidebarViewComposer
{
    public function compose($view)
    {
        $view->menus['content']->put('categories', [
            'weight' => Config::get('categories::admin.weight'),
            'request' => $view->prefix . '/categories*',
            'route' => 'admin.categories.index',
            'icon-class' => 'icon fa fa-fw fa-list-ul',
            'title' => 'Categories',
        ]);
    }
}
