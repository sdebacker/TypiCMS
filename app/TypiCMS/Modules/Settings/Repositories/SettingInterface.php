<?php namespace TypiCMS\Modules\Settings\Repositories;

interface SettingInterface
{

    /**
     * Get all settings
     *
     * @return StdClass Object with $items
     */
    public function getAll($all = false, $relatedModel = null);

    /**
     * Update an existing item
     *
     * @param array  Data to update an item
     * @return boolean
     */
    public function store(array $data);

    /**
     * Build Settings Array
     *
     * @return array
     */
    public function getAllToArray();

    /**
     * Get all Settings from DB
     *
     * @return array
     */
    public function getAllFromDB();

    /**
     * Save to JSON
     *
     * @return void
     */
    public function updateJSON();

}