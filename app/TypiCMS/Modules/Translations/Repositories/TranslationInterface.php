<?php
namespace TypiCMS\Modules\Translations\Repositories;

use TypiCMS\Repositories\RepositoryInterface;

interface TranslationInterface extends RepositoryInterface
{

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
