<?php
namespace TypiCMS\Modules\Dashboard\Composers;

class SidebarViewComposer
{
    public function compose($view)
    {
        $view->items->put('dashboard', [
            'weight' => 0,
            'request' => $view->prefix,
            'route' => 'dashboard',
            'icon-class' => 'icon fa fa-fw fa-dashboard',
            'title' => 'Dashboard',
        ]);
    }
}
