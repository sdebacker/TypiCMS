<?php
namespace TypiCMS\Modules\Groups\Composers;

use Illuminate\Support\Facades\Config;
use Illuminate\View\View;

class SidebarViewComposer
{
    public function compose(View $view)
    {
        $view->menus['users']->put('groups', [
            'weight' => Config::get('groups::admin.weight'),
            'request' => $view->prefix . '/groups*',
            'route' => 'admin.groups.index',
            'icon-class' => 'icon fa fa-fw fa-user',
            'title' => 'Groups',
        ]);
    }
}
