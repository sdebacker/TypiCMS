<?php namespace TypiCMS\Repositories;

use App;
use Input;

abstract class CacheAbstractDecorator {

    protected $repo;
    protected $cache;


    /**
     * Retrieve model by id
     * regardless of status
     *
     * @param  int $id model ID
     * @return stdObject object of model information
     */
    public function byId($id)
    {
        // Build the cache key, unique per model slug
        $key = md5(App::getLocale().'id.'.$id);

        if ( $this->cache->has($key) ) {
            return $this->cache->get($key);
        }

        // Item not cached, retrieve it
        $model = $this->repo->byId($id);

        $this->cache->put($key, $model);

        return $model;
    }


    /**
     * Get paginated models
     *
     * @param int $page Number of models per page
     * @param int $limit Results per page
     * @param boolean $all get published models or all
     * @param array $with Eager load related models
     * @return StdClass Object with $items and $totalItems for pagination
     */
    public function byPage($page = 1, $limit = 10, array $with = array(), $all = false)
    {
        $key = md5(App::getLocale().'byPage.'.$page.$limit.$all.implode(Input::except('page')));

        if ( $this->cache->has($key) ) {
            return $this->cache->get($key);
        }

        $models = $this->repo->byPage($page, $limit, $with, $all);

        // Store in cache for next request
        $this->cache->put($key, $models);

        return $models;
    }


    /**
     * Get all models
     *
     * @param boolean $all Show published or all
     * @param array $with Eager load related models
     * @return StdClass Object with $items
     */
    public function getAll(array $with = array(), $all = false)
    {
        // Build our cache item key, unique per model number,
        // limit and if we're showing all
        $allkey = ($all) ? '.all' : '';
        $key = md5(App::getLocale().'all'.$allkey);

        if ( $this->cache->has($key) ) {
            return $this->cache->get($key);
        }

        // Item not cached, retrieve it
        $models = $this->repo->getAll($with, $all);

        // Store in cache for next request
        $this->cache->put($key, $models);

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
        $key = md5(App::getLocale().'slug.'.$slug);

        if ( $this->cache->has($key) ) {
            return $this->cache->get($key);
        }

        // Item not cached, retrieve it
        $model = $this->repo->bySlug($slug);

        // Store in cache for next request
        $this->cache->put($key, $model);

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
     * @param \Illuminate\Database\Eloquent\Model  $model
     * @param array  $tags
     * @return void
     */
    protected function syncTags($model, array $tags)
    {
        return $this->repo->syncTags($model, $tags);
    }


}