<?php
namespace TypiCMS\Modules\Translations\Composers;

use Illuminate\Support\Facades\Config;

class SidebarViewComposer
{
    public function compose($view)
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
