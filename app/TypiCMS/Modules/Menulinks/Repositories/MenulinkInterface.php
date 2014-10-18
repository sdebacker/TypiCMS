<?php
namespace TypiCMS\Modules\Menulinks\Repositories;

use TypiCMS\Repositories\RepositoryInterface;

interface MenulinkInterface extends RepositoryInterface
{

    /**
     * Get Items to build routes
     *
     * @return Array
     */
    public function getForRoutes();
}
