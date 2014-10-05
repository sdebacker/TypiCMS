<?php
namespace TypiCMS\Modules\Contacts\Composers;

use Illuminate\Support\Facades\Config;

class SidebarViewComposer
{
    public function compose($view)
    {
        $view->menus['contacts']->put('contacts', [
            'weight' => Config::get('contacts::admin.weight'),
            'request' => $view->prefix . '/contacts*',
            'route' => 'admin.contacts.index',
            'icon-class' => 'icon fa fa-fw fa-envelope',
            'title' => 'Contacts',
        ]);
    }
}
