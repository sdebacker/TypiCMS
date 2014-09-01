<?php
namespace TypiCMS\Modules\Menulinks\Repositories;

use TypiCMS\Repositories\RepositoryInterface;

interface MenulinkInterface extends RepositoryInterface
{

    /**
     * Get all models for listing on admin side
     *
     * @param  boolean  $all Show published or all
     * @return StdClass Object with $items
     */
    public function getAllFromMenu($all = false, $relid = null);

    /**
     * Get Items to build routes
     *
     * @return Array
     */
    public function getForRoutes();
}
