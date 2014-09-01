<?php
namespace TypiCMS\Modules\Pages\Repositories;

use TypiCMS\Repositories\RepositoryInterface;

interface PageInterface extends RepositoryInterface
{

    /**
     * Update an existing model
     *
     * @param array  Data to update a model
     * @return boolean
     */
    public function update(array $data);

    /**
     * Get Uris of all pages
     *
     * @return Array[id][lang] = uri
     */
    public function getAllUris();

    /**
     * Get a page by its uri
     *
     * @param  string                      $uri
     * @return TypiCMS\Modules\Models\Page $model
     */
    public function getFirstByUri($uri);

    /**
     * Retrieve children pages
     *
     * @return Collection
     */
    public function getChildren($uri, $all = false);

    /**
     * Get Pages to build routes
     *
     * @return Collection
     */
    public function getForRoutes();

    /**
     * Sort models
     *
     * @param array  Data to update Pages
     * @return boolean
     */
    public function sort(array $data);

    /**
     * Update pages uris
     *
     * @param  int  $id
     * @param $parent
     * @return void
     */
    public function updateUris($id, $parent = null);
}
