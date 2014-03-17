<?php
namespace TypiCMS\Modules\Menulinks\Repositories;

use Illuminate\Support\Collection;

interface MenulinkInterface
{

    /**
     * Get all models
     *
     * @param boolean $all Show published or all
     * @return StdClass Object with $items
     */
    public function getAllFromMenu($all = false, $relid = null);

    /**
     * Get menu's items
     *
     * @param string $name
     * @return StdClass Object with $items
     */
    public function getMenu($name);

    /**
     * Transform collection before building menu
     *
     * @param  array
     * @return string
     */
    public function filter(Collection $models);

    /**
     * Get Items to build routes
     *
     * @return Array
     */
    public function getForRoutes();

}