<?php
namespace TypiCMS\Modules\History\Composers;

use Illuminate\Support\Facades\Config;
use Illuminate\View\View;

class SidebarViewComposer
{
    public function compose(View $view)
    {
        $view->menus['content']->put('history', [
            'weight' => Config::get('history::admin.weight'),
            'request' => $view->prefix . '/history*',
            'route' => 'admin.history.index',
            'icon-class' => 'icon fa fa-fw fa-history',
            'title' => 'History',
        ]);
    }
}
