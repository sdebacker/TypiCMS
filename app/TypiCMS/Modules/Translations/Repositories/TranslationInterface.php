<?php
namespace TypiCMS\Modules\Translations\Repositories;

use TypiCMS\Repositories\RepositoryInterface;

interface TranslationInterface extends RepositoryInterface
{

    /**
     * Get all models
     *
     * @param  boolean  $all  Show published or all
     * @param  array    $with Eager load related models
     * @return StdClass Object with $items
     */
    public function getAll(array $with = array(), $all = false);

    /**
     * Get translations to Array
     *
     * @return array
     */
    public function getAllToArray($locale, $group, $namespace = null);

    /**
     * Create a new model
     *
     * @param array  Data to create a new object
     * @return boolean
     */
    public function create(array $data);

    /**
     * Update an existing model
     *
     * @param array  Data to update a model
     * @return boolean
     */
    public function update(array $data);

    /**
     * Delete model
     *
     * @return boolean
     */
    public function delete($model);
}
