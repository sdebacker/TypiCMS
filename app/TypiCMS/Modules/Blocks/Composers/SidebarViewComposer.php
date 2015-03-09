<?php
namespace TypiCMS\Modules\Blocks\Composers;

use Illuminate\Support\Facades\Config;
use Illuminate\View\View;

class SidebarViewComposer
{
    public function compose(View $view)
    {
        $view->menus['content']->put('blocks', [
            'weight' => Config::get('blocks::admin.weight'),
            'request' => $view->prefix . '/blocks*',
            'route' => 'admin.blocks.index',
            'icon-class' => 'icon fa fa-fw fa-list-alt',
            'title' => 'Blocks',
        ]);
    }
}
