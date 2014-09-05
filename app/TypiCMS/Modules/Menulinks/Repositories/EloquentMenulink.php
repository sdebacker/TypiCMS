<?php
namespace TypiCMS\Modules\Menulinks\Repositories;

use DB;
use Illuminate\Database\Eloquent\Model;
use TypiCMS\Repositories\RepositoriesAbstract;

class EloquentMenulink extends RepositoriesAbstract implements MenulinkInterface
{

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Get all models for listing on admin side
     *
     * @param  boolean  $all Show published or all
     * @return StdClass Object with $items
     */
    public function getAllFromMenu($all = false, $menuId = null)
    {
        $query = $this->model->with('translations')
            ->orderBy('position', 'asc')
            ->where('menu_id', $menuId);

        // All posts or only published
        if (! $all) {
            $query->where('status', 1);
        }

        $models = $query->get()->nest();

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
