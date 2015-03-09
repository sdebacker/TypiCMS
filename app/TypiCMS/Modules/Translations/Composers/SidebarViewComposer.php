<?php
namespace TypiCMS\Modules\Translations\Composers;

use Illuminate\Support\Facades\Config;
use Illuminate\View\View;

class SidebarViewComposer
{
    public function compose(View $view)
    {
        $view->menus['content']->put('translations', [
            'weight' => Config::get('translations::admin.weight'),
            'request' => $view->prefix . '/translations*',
            'route' => 'admin.translations.index',
            'icon-class' => 'icon fa fa-fw fa-comments',
            'title' => 'Translations',
        ]);
    }
}
