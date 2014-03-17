<?php namespace TypiCMS\Modules\Pages\Repositories;

interface PageInterface
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
     * Retrieve children pages
     *
     * @param  int $id model ID
     * @return Collection
     */
    public function getChildren($uri, $all = false);

    /**
     * Build html list
     *
     * @param array
     * @return string
     */
    public function buildSideList($models);

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
     * @param int $id
     * @param $parent
     * @return void
     */
    public function updateUris($id, $parent = null);


}