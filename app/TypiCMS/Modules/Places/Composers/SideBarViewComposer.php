<?php
namespace TypiCMS\Modules\Places\Composers;

use Illuminate\Support\Facades\Config;

class SidebarViewComposer
{
    public function compose($view)
    {
        $view->menus['content']->put('places', [
            'weight' => Config::get('places::admin.weight'),
            'request' => $view->prefix . '/places*',
            'route' => 'admin.places.index',
            'icon-class' => 'icon fa fa-fw fa-map-marker',
            'title' => 'Places',
        ]);
    }
}
