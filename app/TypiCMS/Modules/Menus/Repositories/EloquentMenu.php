<?php
namespace TypiCMS\Modules\Menus\Repositories;

use App;
use HTML;

use Illuminate\Database\Eloquent\Model;

use TypiCMS\Repositories\RepositoriesAbstract;

class EloquentMenu extends RepositoriesAbstract implements MenuInterface
{

    // Class expects an Eloquent model
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Build a menu
     * 
     * @param  string $name       menu name
     * @param  array  $attributes html attributes
     * @return string             html code of a menu
     */
    public function build($name, $attributes = array())
    {
        // check if menu is online
        $menu = $this->model
            ->where('name', $name)
            ->whereHas(
                'translations',
                function ($query) {
                    $query->where('status', 1);
                    $query->where('locale', App::getLocale());
                }
            )
            ->first();
        if (! $menu) return '';

        // get items from menu
        $items = App::make('TypiCMS\Modules\Menulinks\Repositories\MenulinkInterface')->getMenu($name);
        $attributes['class'] = $items->getClass();
        $attributes['id'] = 'nav-' . $name;
        $attributes['role'] = 'menu';

        return HTML::menu($items, $attributes);
    }
}
