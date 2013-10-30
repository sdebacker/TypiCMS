<?php namespace TypiCMS\Repositories\File;

interface FileInterface
{

    /**
     * Retrieve article by id
     * regardless of status
     *
     * @param  int $id File ID
     * @return stdObject object of article information
     */
    public function byId($id);

    /**
     * Get all Files
     *
     * @param boolean $all Show published or all
     * @return StdClass Object with $items
     */
    public function getAll($all = false);

    /**
     * Create a new File
     *
     * @param array  Data to create a new object
     * @return boolean
     */
    public function create(array $data);

    /**
     * Update an existing File
     *
     * @param array  Data to update an File
     * @return boolean
     */
    public function update(array $data);


}