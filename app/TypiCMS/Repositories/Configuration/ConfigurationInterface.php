<?php namespace TypiCMS\Repositories\Configuration;

interface ConfigurationInterface
{

    /**
     * Retrieve article by id
     * regardless of status
     *
     * @param  int $id item ID
     * @return stdObject object of article information
     */
    public function byId($id);

    /**
     * Get all pages
     *
     * @param boolean $all Show published or all
     * @return StdClass Object with $items
     */
    public function getAll($all = false);

    /**
     * Create a new item
     *
     * @param array  Data to create a new object
     * @return boolean
     */
    public function create(array $data);

    /**
     * Update an existing item
     *
     * @param array  Data to update an item
     * @return boolean
     */
    public function update(array $data);


}