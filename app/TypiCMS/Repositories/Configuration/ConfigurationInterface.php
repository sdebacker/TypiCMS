<?php namespace TypiCMS\Repositories\Configuration;

interface ConfigurationInterface
{

    /**
     * Get all pages
     *
     * @return StdClass Object with $items
     */
    public function getAll();

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