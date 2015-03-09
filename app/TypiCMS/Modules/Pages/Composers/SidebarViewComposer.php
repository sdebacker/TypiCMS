<?php
namespace TypiCMS\Modules\Pages\Composers;

use Illuminate\Support\Facades\Config;
use Illuminate\View\View;

class SidebarViewComposer
{
    public function compose(View $view)
    {
        $view->menus['content']->put('pages', [
            'weight' => Config::get('pages::admin.weight'),
            'request' => $view->prefix . '/pages*',
            'route' => 'admin.pages.index',
            'icon-class' => 'icon fa fa-fw fa-file',
            'title' => 'Pages',
        ]);
    }
}
