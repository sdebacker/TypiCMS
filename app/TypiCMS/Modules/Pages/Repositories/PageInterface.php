<?php namespace TypiCMS\Modules\Pages\Repositories;

interface PageInterface
{

    /**
     * Retrieve article by id
     * regardless of status
     *
     * @param  int $id Article ID
     * @return stdObject object of article information
     */
    public function byId($id);

    /**
     * Get paginated articles
     *
     * @param int  Number of articles per page
     * @return StdClass Object with $items and $totalItems for pagination
     */
    public function byPage($page = 1, $limit = 10);

    /**
     * Get Home page
     *
     * @return model
     */
    public function getHomePage();

    /**
     * Get all pages
     *
     * @param boolean $all Show published or all
     * @return StdClass Object with $items
     */
    public function getAll($all = false);

    /**
     * Get single article by URL
     *
     * @param string  URL slug of article
     * @return object object of article information
     */
    public function bySlug($slug);

    /**
     * Create a new Article
     *
     * @param array  Data to create a new object
     * @return boolean
     */
    public function create(array $data);

    /**
     * Update an existing Article
     *
     * @param array  Data to update an Article
     * @return boolean
     */
    public function update(array $data);

    /**
     * Get Uris of all pages
     *
     * @return Array[id][lang] = uri
     */
    public function getAllUris();


}