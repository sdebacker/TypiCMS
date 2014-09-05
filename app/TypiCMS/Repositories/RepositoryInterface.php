<?php
namespace TypiCMS\Repositories;

interface RepositoryInterface
{
    /**
     * get empty model
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function getModel();

    /**
     * Make a new instance of the entity to query on
     *
     * @param array $with
     */
    public function make(array $with = array());

    /**
     * Find a single entity by key value
     *
     * @param string $key
     * @param string $value
     * @param array  $with
     */
    public function getFirstBy($key, $value, array $with = array('translations'), $all = false);

    /**
     * Retrieve model by id
     * regardless of status
     *
     * @param  int       $id model ID
     * @return stdObject object of model information
     */
    public function byId($id, array $with = array('translations'));

    /**
     * Get paginated models
     *
     * @param  int      $page  Number of models per page
     * @param  int      $limit Results per page
     * @param  boolean  $all   get published models or all
     * @param  array    $with  Eager load related models
     * @return StdClass Object with $items && $totalItems for pagination
     */
    public function byPage($page = 1, $limit = 10, array $with = array('translations'), $all = false);

    /**
     * Get all models
     *
     * @param  array       $with Eager load related models
     * @param  boolean     $all  Show published or all
     * @return \Illuminate\Database\Eloquent\Collection|\TypiCMS\NestedCollection
     */
    public function getAll(array $with = array('translations'), $all = false);

    /**
     * Get all models and nest
     *
     * @param  boolean                    $all  Show published or all
     * @param  array                      $with Eager load related models
     * @return \TypiCMS\NestedCollection  with $items
     */
    public function getAllNested(array $with = array('translations'), $all = false);

    /**
     * Get all models with categories
     *
     * @param  boolean                                  $all Show published or all
     * @return \Illuminate\Database\Eloquent\Collection Object with $items
     */
    public function getAllBy($key, $value, array $with = array('translations'), $all = false);

    /**
     * Get latest models
     *
     * @param  integer      $number number of items to take
     * @param  array        $with array of related items
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function latest($number = 10, array $with = array('translations'));

    /**
     * Get single model by Slug
     *
     * @param  string $slug slug
     * @param  array  $with related tables
     * @return mixed
     */
    public function bySlug($slug, array $with = array('translations'));

    /**
     * Return all results that have a required relationship
     *
     * @param string $relation
     * @param array  $with
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function has($relation, array $with = array());

    /**
     * Create a new model
     *
     * @param array  Data needed for model creation
     * @return mixed Model or false on error during save
     */
    public function create(array $data);

    /**
     * Update an existing model
     *
     * @param array  Data needed for model update
     * @return boolean
     */
    public function update(array $data);

    /**
     * Sort models
     *
     * @param array  Data to update Pages
     * @return boolean
     */
    public function sort(array $data);

    /**
     * Build a select menu for a module
     *
     * @param  string  $method     with method to call from the repository ?
     * @param  boolean $firstEmpty generate an empty item
     * @param  string  $value      witch field as value ?
     * @param  string  $key        witch field as key ?
     * @return array               array with key = $key and value = $value
     */
    public function select($method = 'getAll', $firstEmpty = false, $value = 'title', $key = 'id');

    /**
     * Get all translated pages for a select/options
     *
     * @return array
     */
    public function getPagesForSelect();

    /**
     * Get all modules for a select/options
     *
     * @return array
     */
    public function getModulesForSelect();

    /**
     * Delete model
     *
     * @return boolean
     */
    public function delete($model);
}
