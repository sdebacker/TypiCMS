<?php
namespace TypiCMS;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Config;

class SideBarViewCreator
{
    public function create($view)
    {
        $view->prefix = 'admin';
        $view->menus = [
            0          => new Collection,
            'contacts' => new Collection,
            'content'  => new Collection,
            'media'    => new Collection,
            'users'    => new Collection,
        ];
    }
}
