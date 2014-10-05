<?php
namespace TypiCMS\Modules\Galleries\Composers;

use Illuminate\Support\Facades\Config;

class SidebarViewComposer
{
    public function compose($view)
    {
        $view->menus['media']->put('galleries', [
            'weight' => Config::get('galleries::admin.weight'),
            'request' => $view->prefix . '/galleries*',
            'route' => 'admin.galleries.index',
            'icon-class' => 'icon fa fa-fw fa-photo',
            'title' => 'Galleries',
        ]);
    }
}
