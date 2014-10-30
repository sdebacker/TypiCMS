<?php
namespace TypiCMS\Modules\Menulinks\Repositories;

use Illuminate\Database\Eloquent\Collection;
use TypiCMS\Repositories\RepositoryInterface;

interface MenulinkInterface extends RepositoryInterface
{

    /**
     * Get a menu’s items and children
     *
     * @param  integer  $id
     * @param  boolean  $all published or all
     * @return Collection
     */
    public function getAllFromMenu($id = null, $all = false);

    /**
     * Get Items to build routes
     *
     * @return Array
     */
    public function getForRoutes();
}
