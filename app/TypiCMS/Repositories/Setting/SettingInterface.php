<?php namespace TypiCMS\Repositories\Setting;

interface SettingInterface
{

    /**
     * Get all pages
     *
     * @return StdClass Object with $items
     */
    public function getAll();

    /**
     * Update an existing item
     *
     * @param array  Data to update an item
     * @return boolean
     */
    public function store(array $data);


}