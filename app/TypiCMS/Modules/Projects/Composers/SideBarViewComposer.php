<?php
namespace TypiCMS\Modules\Projects\Composers;

use Illuminate\Support\Facades\Config;

class SidebarViewComposer
{
    public function compose($view)
    {
        $view->menus['content']->put('projects', [
            'weight' => Config::get('projects::admin.weight'),
            'request' => $view->prefix . '/projects*',
            'route' => 'admin.projects.index',
            'icon-class' => 'icon fa fa-fw fa-cube',
            'title' => 'Projects',
        ]);
    }
}
