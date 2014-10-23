<?php
namespace TypiCMS\Modules\Menulinks\Repositories;

use DB;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use TypiCMS\Repositories\RepositoriesAbstract;

class EloquentMenulink extends RepositoriesAbstract implements MenulinkInterface
{

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Get a menu’s items and children
     *
     * @param  integer  $id
     * @param  boolean  $all published or all
     * @return Collection
     */
    public function getAllFromMenu($id = null, $all = false)
    {
        $query = $this->model
            ->with('translations', 'children', 'children.children')
            ->order()
            ->where('menulink_id', 0)
            ->where('menu_id', $id);

        // All posts or only published
        if (! $all) {
            $query->where('status', 1);
        }

        return $query->get();
    }

    /**
     * Get Items to build routes
     *
     * @return Array
     */
    public function getForRoutes()
    {
        $menulinks = DB::table('menulinks')
            ->select('menulinks.id', 'menulinks.menulink_id', 'uri', 'locale', 'module_name')
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
