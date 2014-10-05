<?php
namespace TypiCMS\Modules\News\Composers;

use Illuminate\Support\Facades\Config;

class SidebarViewComposer
{
    public function compose($view)
    {
        $view->menus['content']->put('news', [
            'weight' => Config::get('news::admin.weight'),
            'request' => $view->prefix . '/news*',
            'route' => 'admin.news.index',
            'icon-class' => 'icon fa fa-fw fa-bullhorn',
            'title' => 'News',
        ]);
    }
}
