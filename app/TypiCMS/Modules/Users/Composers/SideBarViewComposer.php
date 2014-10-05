<?php
namespace TypiCMS\Modules\Users\Composers;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Request;

class SidebarViewComposer
{
    public function compose($view)
    {
        $view->items->put('user', Collection::make([
            [
                'weight' => '1',
                'request' => Request::is($view->prefix . '/users*') or Request::is($view->prefix . '/groups*'),
                'route' => '#',
                'icon-class' => null,
                'title' => 'Users',
            ],
            [
                'request' => $view->prefix . '/users*',
                'route' => 'admin.users.index',
                'icon-class' => 'icon fa fa-fw fa-user',
                'title' => 'Users',
            ],
            [
                'request' => $view->prefix . '/groups*',
                'route' => 'admin.groups.index',
                'icon-class' => 'icon fa fa-fw fa-group',
                'title' => 'Groups',
            ]
        ]));
    }
}
