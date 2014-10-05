<?php
namespace TypiCMS\Modules\Events\Composers;

use Illuminate\Support\Facades\Config;

class SidebarViewComposer
{
    public function compose($view)
    {
        $view->menus['content']->put('events', [
            'weight' => Config::get('events::admin.weight'),
            'request' => $view->prefix . '/events*',
            'route' => 'admin.events.index',
            'icon-class' => 'icon fa fa-fw fa-calendar',
            'title' => 'Events',
        ]);
    }
}
