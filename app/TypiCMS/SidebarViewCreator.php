<?php
namespace TypiCMS;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Config;

class SidebarViewCreator
{
    public function create($view)
    {
        $view->prefix = Config::get('app.admin-prefix');
        $view->items = new Collection;
    }
}
