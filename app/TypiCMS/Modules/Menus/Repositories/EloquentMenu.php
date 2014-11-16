<?php
namespace TypiCMS\Modules\Menus\Repositories;

use App;
use Categories;
use Config;
use ErrorException;
use HTML;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Notification;
use Request;
use TypiCMS\Modules\Menulinks\Models\Menulink;
use TypiCMS\Repositories\RepositoriesAbstract;

class EloquentMenu extends RepositoriesAbstract implements MenuInterface
{

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Get all menus
     *
     * @return array with key = menu name and value = menu model
     */
    public function getAllMenus()
    {
        $with = [
            'translations',
            'menulinks.translations',
            'menulinks.page.translations',
        ];
        $menus = $this->make($with)
            ->whereHas(
                'translations',
                function (Builder $query) {
                    $query->where('status', 1);
                    $query->where('locale', App::getLocale());
                }
            )
            ->get();

        $menusArray = array();
        foreach ($menus as $menu) {

            // remove offline items from each menu
            $menu->menulinks = $menu->menulinks->filter(function (Menulink $menulink) {
                if ($menulink->status == 1) {
                    return true;
                }
            });

            $menusArray[$menu->name] = $menu;
        }

        return $menusArray;
    }

    /**
     * Get a menu
     *
     * @param  string $name menu name
     * @return Model  $menu nested collection
     */
    public function getMenu($name)
    {
        try {
            $menu = App::make('TypiCMS.menus')[$name];
        } catch (ErrorException $e) {
            Notification::error(
                trans('menus::global.No menu found with name “:name”', ['name' => $name])
            );
            return null;
        }

        if (! $menu) {
            return null;
        }

        $menu->menulinks = $this->prepare($menu->menulinks);

        $menu->menulinks->nest();

        return $menu;
    }

    public function prepare($items = null)
    {
        $items->each(function ($item) {
            if ($item->has_categories) {
                $item->items = $this->prepare(Categories::getAllForMenu($item->uri));
            }
            $item->uri = $this->setUri($item);
            $item->class = $this->setClass($item);
        });

        return $items;
    }

    /**
     * Build a menu
     *
     * @param  string $name       menu name
     * @return mixed null or string (html code of a menu)
     */
    public function build($name)
    {
        if (! $menu = $this->getMenu($name)) {
            return null;
        }

        $attributes = [
            'class' => $menu->class,
            'id' => 'nav-' . $name,
            'role' => 'menu',
        ];

        return HTML::menu($menu->menulinks, $attributes);
    }

    /**
     * 1. Uri = menulink->uri
     * 2. if menulink has a page, take the uri of the page
     * 3. if menulink has url field, take it
     *
     * @param Model   $menulink
     * @return string uri
     */
    public function setUri($menulink)
    {
        if ($menulink->url) {
            return $menulink->url;
        }

        // when menu item has a page, take page’s uri.
        if ($menulink->page) {
            $uri = $menulink->page->uri;
            if ($menulink->page->is_home) {
                $uri = Config::get('app.locale');
                // Set uri to '/' for home page in main locale (fallback_locale)
                // only when langChooser is disabled and app.main_locale_in_url is false
                if (
                    ! Config::get('typicms.langChooser') &&
                    Config::get('app.fallback_locale') == App::getLocale() &&
                    ! Config::get('app.main_locale_in_url')
                ) {
                    $uri = '';
                }
            }
            return '/' . $uri;
        }

        return '/' . $menulink->uri;

    }

    /**
     * Take the classes from field and add active if needed
     *
     * @param Model   $menulink
     * @return string classes
     */
    public function setClass($menulink)
    {
        $activeUri = Request::path();
        if ($activeUri != '/') {
            $activeUri = '/' . $activeUri;
        }
        $classArray = preg_split('/ /', $menulink->class, null, PREG_SPLIT_NO_EMPTY);
        // add active class if item uri equals current uri
        // or current uri contain item uri
        // item uri must be bigger than 3 to avoid homepage link always active ('/', '/lg')
        if ($menulink->uri == $activeUri ||
                (
                    strlen($menulink->uri) > 3 &&
                    preg_match('@^'.$menulink->uri.'@', $activeUri)
                )
            ) {
            $classArray[] = 'active';
        }
        return implode(' ', $classArray);
    }
}
