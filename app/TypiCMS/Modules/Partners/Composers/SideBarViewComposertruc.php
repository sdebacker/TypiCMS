<?php
namespace TypiCMS\Modules\Partners\Composers;

use Illuminate\Support\Facades\Config;
use Illuminate\View\View;

class SidebarViewComposer
{
    public function compose(View $view)
    {
        $view->menus['content']->put('partners', [
            'weight' => Config::get('partners::admin.weight'),
            'request' => $view->prefix . '/partners*',
            'route' => 'admin.partners.index',
            'icon-class' => 'icon fa fa-fw fa-cubes',
            'title' => 'Partners',
        ]);
    }
}
