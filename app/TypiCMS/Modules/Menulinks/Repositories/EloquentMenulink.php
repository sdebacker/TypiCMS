<?php namespace TypiCMS\Modules\Menulinks\Repositories;

use DB;
use Config;
use Request;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;

use TypiCMS\Repositories\RepositoriesAbstract;

class EloquentMenulink extends RepositoriesAbstract implements MenulinkInterface
{

    // Class expects an Eloquent model
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Get all models
     *
     * @param boolean $all Show published or all
     * @return StdClass Object with $items
     */
    public function getAllFromMenu($all = false, $relid = null)
    {
        $query = $this->model->with('translations')
            ->orderBy('position', 'asc')
            ->where('menu_id', $relid);

        // All posts or only published
        if ( ! $all ) {
            $query->where('status', 1);
        }

        $models = $query->get()->nest();

        return $models;
    }


    /**
     * Build a menu from its name
     *
     * @return Menulinks Collection
     */
    public function getMenu($name)
    {

        $models = $this->model->select('menus.name', 'menus.class AS menuclass', 'menulinks.id', 'menulinks.menu_id', 'menulinks.target', 'menulinks.parent', 'menulinks.page_id', 'menulinks.class', 'menulink_translations.title', 'menulink_translations.status', 'menulink_translations.url', 'pages.is_home', 'page_translations.uri as page_uri', 'page_translations.locale', 'module_name')
            
            ->with('translations')
            ->join('menus', 'menulinks.menu_id', '=', 'menus.id')
            ->join('menulink_translations', 'menulinks.id', '=', 'menulink_translations.menulink_id')
            ->leftJoin('pages', 'pages.id', '=', 'menulinks.page_id')
            ->leftJoin('page_translations', 'page_translations.page_id', '=', 'menulinks.page_id')

            ->where('menulink_translations.locale', Config::get('app.locale'))
            ->where(function($query){
                $query->where('page_translations.locale', Config::get('app.locale'));
                $query->orWhere('page_translations.locale', null);
            })
            ->where('menus.name', $name)
            ->where('menulink_translations.status', 1)

            ->orderBy('menulinks.position')
            ->get();

        if ( ! $models->isEmpty()) {
            $models->setClass($models->first()->menuclass);
        }

        $models = $this->filter($models)->nest();

        return $models;

    }


    /**
     * Adapt the colelction before building menu
     *
     * @param  array
     * @return string
     */
    private function filter(Collection $models)
    {
        $models->each(function($menulink) {

            // Homepage
            if ($menulink->is_home) {
                $menulink->page_uri = Config::get('app.locale');
            }

            // Link to URI (module for example)
            if ($menulink->uri) {
                $menulink->page_uri = $menulink->uri;
            }

            $menulink->page_uri = '/' . $menulink->page_uri;

            // Link to URL
            if ($menulink->url) {
                $menulink->page_uri = $menulink->url;
            }

            $activeUri = '/' . Request::path();

            if ( $menulink->page_uri == $activeUri or ( strlen($menulink->page_uri) > 3 and preg_match('@^'.$menulink->page_uri.'@', $activeUri) ) ) {
                // if item uri equals current uri
                // or current uri contain item uri (item uri must be bigger than 3 to avoid homepage link always active)
                // then add active class.
                $classArray = preg_split('/ /', $menulink->class, NULL, PREG_SPLIT_NO_EMPTY);
                $classArray[] = 'active';
                $menulink->class = implode(' ', $classArray);
            }
        });

        return $models;

    }


    /**
     * Get Items to build routes
     *
     * @return Array
     */
    public function getForRoutes()
    {
        $menulinks = DB::table('menulinks')
            ->select('menulinks.id', 'menulink_id', 'uri', 'locale', 'module_name')
            ->join('menulink_translations', 'menulinks.id', '=', 'menulink_translations.menulink_id')
            ->where('uri', '!=', '')
            ->where('module_name', '!=', '')
            ->where('status', '=', 1)
            ->orderBy('module_name')
            ->get();

        $menulinksArray = array();
        foreach ($menulinks as $menulink) {
            $menulinksArray[$menulink->module_name][$menulink->locale] = $menulink->uri;
        }

        return $menulinksArray;
    }

}