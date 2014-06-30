<?php
namespace TypiCMS\Modules\Menus\Repositories;

use App;
use HTML;
use Config;
use Request;

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
     * Get a menu by its name for public side
     * 
     * @param  string $name menu name
     * @return Model
     */
    public function getByName($name)
    {
        $with = [
            'menulinks',
            'menulinks.translations',
            'menulinks.page',
            'menulinks.page.translations',
        ];
        $menu = $this->make($with)
            ->where('name', $name)
            ->whereHas(
                'translations',
                function ($query) {
                    $query->where('status', 1);
                    $query->where('locale', App::getLocale());
                }
            )
            ->first();

        return $menu;
    }

    /**
     * Build a menu
     * 
     * @param  string $name       menu name
     * @return string             html code of a menu
     */
    public function build($name)
    {
        $menu = App::make('TypiCMS\Modules\Menus\Repositories\MenuInterface')->getByName($name);

        if (! $menu) {
            return null;
        }

        $menu->menulinks->each(function ($menulink) {
            $menulink->uri = $this->setUri($menulink);
            $menulink->class = $this->setClass($menulink);
        });

        $menu->menulinks->sortBy(function ($menulink) {
            return $menulink->position;
        });

        $menu->menulinks->nest();

        $attributes = [
            'class' => $menu->class,
            'id' => 'nav-' . $name,
            'role' => 'menu',
        ];

        return HTML::menu($menu->menulinks, $attributes);
    }

    /**
     * 1. Uri = menulink->uri or
     * 2. if page linke, take the uri of the page or
     * 3. if url field filled, take it
     * 
     * @param Model   $menulink
     * @return string uri
     */
    public function setUri($menulink)
    {
        $uri = $menulink->uri;

        if ($menulink->page) {
            if ($menulink->page->is_home) {
                $uri = Config::get('app.locale');
            } else {
                $uri = $menulink->page->uri;
            }
        }

        $uri = '/' . $uri;

        if ($menulink->url) {
            $uri = $menulink->url;
        }

        return $uri;

    }

    /**
     * Take the classes from field and add active if needed
     * 
     * @param Model   $menulink
     * @return string classes
     */
    public function setClass($menulink)
    {
        $activeUri = '/' . Request::path();
        if ($menulink->uri == $activeUri or
                (
                    strlen($menulink->uri) > 3 and
                    preg_match('@^'.$menulink->uri.'@', $activeUri)
                )
            ) {
            // if item uri equals current uri
            // or current uri contain item uri (item uri must be bigger than 3 to avoid homepage link always active)
            // then add active class.
            $classArray = preg_split('/ /', $menulink->class, null, PREG_SPLIT_NO_EMPTY);
            $classArray[] = 'active';
            return implode(' ', $classArray);
        }
        return $menulink->class;
    }
}
