<?php
namespace TypiCMS\Modules\Users\Composers;

use Illuminate\Support\Facades\Config;

class SidebarViewComposer
{
    public function compose($view)
    {
        $view->menus['users']->put('users', [
            'weight' => Config::get('users::admin.weight'),
            'request' => $view->prefix . '/users*',
            'route' => 'admin.users.index',
            'icon-class' => 'icon fa fa-fw fa-user',
            'title' => 'Users',
        ]);
    }
}
