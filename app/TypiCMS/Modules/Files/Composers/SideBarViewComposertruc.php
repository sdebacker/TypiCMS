<?php
namespace TypiCMS\Modules\Files\Composers;

use Illuminate\Support\Facades\Config;
use Illuminate\View\View;

class SidebarViewComposer
{
    public function compose(View $view)
    {
        $view->menus['media']->put('files', [
            'weight' => Config::get('files::admin.weight'),
            'request' => $view->prefix . '/files*',
            'route' => 'admin.files.index',
            'icon-class' => 'icon fa fa-fw fa-file-photo-o',
            'title' => 'Files',
        ]);
    }
}
