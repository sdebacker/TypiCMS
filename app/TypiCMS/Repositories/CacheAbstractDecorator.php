<?php
namespace TypiCMS\Repositories;

use App;
use Input;

abstract class CacheAbstractDecorator
{
    protected $repo;
    protected $cache;

    public function getModel()
    {
        return $this->repo->getModel();
    }

    /**
     * Retrieve model by id
     * regardless of status
     *
     * @param  int       $id model ID
     * @return stdObject object of model information
     */
    public function byId($id)
    {
        // Build the cache key, unique per model slug
        $cacheKey = md5(App::getLocale().'id.'.$id);

        if ($this->cache->has($cacheKey)) {
            return $this->cache->get($cacheKey);
        }

        // Item not cached, retrieve it
        $model = $this->repo->byId($id);

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
    public function getFirstBy($key, $value, array $with = array(), $all = false)
    {
        // Build the cache key, unique per model slug
        $cacheKey = md5(App::getLocale() . 'getFirstBy' . $key . $value . implode($with) . $all);

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
     * @return StdClass Object with $items and $totalItems for pagination
     */
    public function byPage($page = 1, $limit = 10, array $with = array(), $all = false)
    {
        $cacheKey = md5(App::getLocale() . 'byPage' . $page . $limit . implode($with) . $all . implode(Input::except('page')));

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
    public function getAll(array $with = array(), $all = false)
    {
        $cacheKey = md5(App::getLocale() . 'all' . implode($with) . $all . implode(Input::except('page')));

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
     * Get all models with categories
     *
     * @param  boolean  $all Show published or all
     * @return StdClass Object with $items
     */
    public function getAllBy($key, $value, array $with = array(), $all = false)
    {
        $cacheKey = md5(App::getLocale() . 'getAllBy' . $key . $value . implode($with) . $all);

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
        $cacheKey = md5(App::getLocale() . 'latest' . $number . implode($with));

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
     * Get single model by URL
     *
     * @param string  URL slug of model
     * @return object object of model information
     */
    public function bySlug($slug)
    {
        // Build the cache key, unique per model slug
        $cacheKey = md5(App::getLocale() . 'bySlug' . $slug);

        if ($this->cache->has($cacheKey)) {
            return $this->cache->get($cacheKey);
        }

        // Item not cached, retrieve it
        $model = $this->repo->bySlug($slug);

        // Store in cache for next request
        $this->cache->put($cacheKey, $model);

        return $model;

    }

    /**
     * Get single model by URL
     *
     * @param string  URL slug of model
     * @return object object of model information
     */
    public function has($relation, array $with = array())
    {
        // Build the cache key, unique per model slug
        $cacheKey = md5(App::getLocale() . 'has' . implode($with) . $relation);

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
     * @param array  Data to create a new object
     * @return boolean or model
     */
    public function create(array $data)
    {
        $model = $this->repo->create($data);
        if ($model) {
            $this->cache->flush();
            $this->cache->flush('Dashboard');
        }

        return $model;
    }

    /**
     * Update an existing model
     *
     * @param array  Data to update a model
     * @return boolean
     */
    public function update(array $data)
    {
        $bool = $this->repo->update($data);
        $this->cache->flush();

        return $bool;
    }

    /**
     * Sort models
     *
     * @param array  Data to update Pages
     * @return boolean
     */
    public function sort(array $data)
    {
        $bool = $this->repo->sort($data);
        $this->cache->flush();

        return $bool;
    }

    public function getModulesForSelect()
    {
        return $this->repo->getModulesForSelect();
    }

    public function delete($model)
    {
        $bool = $this->repo->delete($model);
        $this->cache->flush();
        $this->cache->flush('Dashboard');

        return $bool;
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
