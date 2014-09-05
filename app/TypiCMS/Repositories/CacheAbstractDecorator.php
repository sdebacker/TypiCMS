<?php
namespace TypiCMS\Repositories;

use App;
use Input;
use TypiCMS\Repositories\RepositoryInterface;

abstract class CacheAbstractDecorator implements RepositoryInterface
{
    protected $repo;
    protected $cache;

    public function getModel()
    {
        return $this->repo->getModel();
    }

    /**
     * Make a new instance of the entity to query on
     *
     * @param array $with
     */
    public function make(array $with = array())
    {
        return $this->repo->make($with);
    }

    /**
     * Retrieve model by id
     * regardless of status
     *
     * @param  int       $id model ID
     * @return stdObject object of model information
     */
    public function byId($id, array $with = array('translations'))
    {
        // Build the cache key, unique per model slug
        $cacheKey = md5(App::getLocale() . 'id.' . implode('.', $with) . $id . implode('.', Input::all()));

        if ($this->cache->has($cacheKey)) {
            return $this->cache->get($cacheKey);
        }

        // Item not cached, retrieve it
        $model = $this->repo->byId($id, $with);

        $this->cache->put($cacheKey, $model);

        return $model;
    }

    /**
     * Find a single entity by key value
     *
     * @param string $key
     * @param string $value
     * @param array  $with
     */
    public function getFirstBy($key, $value, array $with = array('translations'), $all = false)
    {
        // Build the cache key, unique per model slug
        $cacheKey = md5(App::getLocale().'getFirstBy'.$key.$value.implode('.', $with).$all.implode('.', Input::all()));

        if ($this->cache->has($cacheKey)) {
            return $this->cache->get($cacheKey);
        }

        // Item not cached, retrieve it
        $model = $this->repo->getFirstBy($key, $value, $with, $all);

        $this->cache->put($cacheKey, $model);

        return $model;
    }

    /**
     * Get paginated models
     *
     * @param  int      $page  Number of models per page
     * @param  int      $limit Results per page
     * @param  boolean  $all   get published models or all
     * @param  array    $with  Eager load related models
     * @return StdClass Object with $items && $totalItems for pagination
     */
    public function byPage($page = 1, $limit = 10, array $with = array('translations'), $all = false)
    {
        $cacheKey = md5(App::getLocale().'byPage'.$page.$limit.implode('.', $with).$all.implode('.', Input::except('page')));

        if ($this->cache->has($cacheKey)) {
            return $this->cache->get($cacheKey);
        }

        $models = $this->repo->byPage($page, $limit, $with, $all);

        // Store in cache for next request
        $this->cache->put($cacheKey, $models);

        return $models;
    }

    /**
     * Get all models
     *
     * @param  boolean  $all  Show published or all
     * @param  array    $with Eager load related models
     * @return StdClass Object with $items
     */
    public function getAll(array $with = array('translations'), $all = false)
    {
        $cacheKey = md5(App::getLocale() . 'all' . implode('.', $with) . $all . implode('.', Input::except('page')));

        if ($this->cache->has($cacheKey)) {
            return $this->cache->get($cacheKey);
        }

        // Item not cached, retrieve it
        $models = $this->repo->getAll($with, $all);

        // Store in cache for next request
        $this->cache->put($cacheKey, $models);

        return $models;
    }

    /**
     * Get all models and nest
     *
     * @param  boolean                    $all  Show published or all
     * @param  array                      $with Eager load related models
     * @return \TypiCMS\NestedCollection  with $items
     */
    public function getAllNested(array $with = array('translations'), $all = false)
    {
        $cacheKey = md5(App::getLocale() . 'allNested' . implode('.', $with) . $all . implode('.', Input::except('page')));

        if ($this->cache->has($cacheKey)) {
            return $this->cache->get($cacheKey);
        }

        // Item not cached, retrieve it
        $models = $this->repo->getAllNested($with, $all);

        // Store in cache for next request
        $this->cache->put($cacheKey, $models);

        return $models;
    }

    /**
     * Get all models with categories
     *
     * @param  boolean  $all Show published or all
     * @return StdClass Object with $items
     */
    public function getAllBy($key, $value, array $with = array('translations'), $all = false)
    {
        $cacheKey = md5(App::getLocale().'getAllBy'.$key.$value.implode('.', $with).$all.implode('.', Input::all()));

        if ($this->cache->has($cacheKey)) {
            return $this->cache->get($cacheKey);
        }

        // Item not cached, retrieve it
        $models = $this->repo->getAllBy($key, $value, $with, $all);

        // Store in cache for next request
        $this->cache->put($cacheKey, $models);

        return $models;
    }

    /**
     * Get latest models
     *
     * @param  integer      $number number of items to take
     * @param  array        $with array of related items
     * @return Collection
     */
    public function latest($number = 10, array $with = array('translations'))
    {
        $cacheKey = md5(App::getLocale() . 'latest' . $number . implode('.', $with) . implode('.', Input::all()));

        if ($this->cache->has($cacheKey)) {
            return $this->cache->get($cacheKey);
        }

        // Item not cached, retrieve it
        $models = $this->repo->latest($number, $with);

        // Store in cache for next request
        $this->cache->put($cacheKey, $models);

        return $models;
    }

    /**
     * Get single model by slug
     *
     * @param  string $slug of model
     * @param  array  $with
     * @return object object of model information
     */
    public function bySlug($slug, array $with = array('translations'))
    {
        // Build the cache key, unique per model slug
        $cacheKey = md5(App::getLocale() . 'bySlug' . $slug . implode('.', $with) . implode('.', Input::all()));

        if ($this->cache->has($cacheKey)) {
            return $this->cache->get($cacheKey);
        }

        // Item not cached, retrieve it
        $model = $this->repo->bySlug($slug, $with);

        // Store in cache for next request
        $this->cache->put($cacheKey, $model);

        return $model;

    }

    /**
     * Return all results that have a required relationship
     *
     * @param string $relation
     * @param array  $with
     */
    public function has($relation, array $with = array())
    {
        // Build the cache key, unique per model slug
        $cacheKey = md5(App::getLocale() . 'has' . implode('.', $with) . $relation);

        if ($this->cache->has($cacheKey)) {
            return $this->cache->get($cacheKey);
        }

        // Item not cached, retrieve it
        $model = $this->repo->has($relation, $with);

        // Store in cache for next request
        $this->cache->put($cacheKey, $model);

        return $model;

    }

    /**
     * Create a new model
     *
     * @param array  Data needed for model creation
     * @return mixed Model or false on error during save
     */
    public function create(array $data)
    {
        $this->cache->flush();
        $this->cache->flush('dashboard');
        return $this->repo->create($data);
    }

    /**
     * Update an existing model
     *
     * @param array  Data needed for model update
     * @return boolean
     */
    public function update(array $data)
    {
        $this->cache->flush();
        return $this->repo->update($data);
    }

    /**
     * Sort models
     *
     * @param array  Data to update Pages
     * @return boolean|null
     */
    public function sort(array $data)
    {
        $this->cache->flush();
        $this->repo->sort($data);
    }

    /**
     * Build a select menu for a module
     *
     * @param  string  $method     with method to call from the repository ?
     * @param  boolean $firstEmpty generate an empty item
     * @param  string  $value      witch field as value ?
     * @param  string  $key        witch field as key ?
     * @return array               array with key = $key and value = $value
     */
    public function select($method = 'getAll', $firstEmpty = false, $value = 'title', $key = 'id')
    {
        return $this->repo->select($method, $firstEmpty, $value, $key);
    }

    /**
     * Get all translated pages for a select/options
     *
     * @return array
     */
    public function getPagesForSelect()
    {
        return $this->repo->getPagesForSelect();
    }

    /**
     * Get all modules for a select/options
     *
     * @return array
     */
    public function getModulesForSelect()
    {
        return $this->repo->getModulesForSelect();
    }

    /**
     * Delete model
     *
     * @return boolean
     */
    public function delete($model)
    {
        $this->cache->flush();
        $this->cache->flush('dashboard');
        return $this->repo->delete($model);
    }

    /**
     * Sync tags for model
     *
     * @param  \Illuminate\Database\Eloquent\Model $model
     * @param  array                               $tags
     * @return void
     */
    protected function syncTags($model, array $tags)
    {
        return $this->repo->syncTags($model, $tags);
    }
}
