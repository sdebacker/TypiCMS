<?php
namespace TypiCMS\Modules\Menus\Composers;

use Illuminate\Support\Facades\Config;

class SidebarViewComposer
{
    public function compose($view)
    {
        $view->menus['content']->put('menus', [
            'weight' => Config::get('menus::admin.weight'),
            'request' => $view->prefix . '/menus*',
            'route' => 'admin.menus.index',
            'icon-class' => 'icon fa fa-fw fa-bars',
            'title' => 'Menus',
        ]);
    }
}
