<?php
namespace TypiCMS\Modules\Pages\Repositories;

use TypiCMS\Repositories\RepositoryInterface;

interface PageInterface extends RepositoryInterface
{

    /**
     * Get a page by its uri
     *
     * @param  string                      $uri
     * @return TypiCMS\Modules\Models\Page $model
     */
    public function getFirstByUri($uri);

    /**
     * Get submenu for a page
     *
     * @return Collection
     */
    public function getSubMenu($uri, $all = false);

    /**
     * Get Pages to build routes
     *
     * @return Collection
     */
    public function getForRoutes();

    /**
     * Get all uris
     *
     * @return array
     */
    public function getAllUris();
}
