<?php namespace TypiCMS\Modules\Projects\Repositories;

use App;
use Config;
use Request;

use TypiCMS\Repositories\CacheAbstractDecorator;
use TypiCMS\Services\Cache\CacheInterface;

class CacheDecorator extends CacheAbstractDecorator implements ProjectInterface
{

    // Class expects a repo and a cache interface
    public function __construct(ProjectInterface $repo, CacheInterface $cache)
    {
        $this->repo = $repo;
        $this->cache = $cache;
    }


    /**
     * Get all models with categories
     *
     * @param boolean $all Show published or all
     * @return StdClass Object with $items
     */
    public function getAll($all = false, $relid = null)
    {
        $key = md5(App::getLocale().'all'.$all.$relid);

        if ( $this->cache->has($key) ) {
            return $this->cache->get($key);
        }

        $models = $this->repo->getAll($all, $relid);

        // Store in cache for next request
        $this->cache->put($key, $models);

        return $models;
    }


    /**
     * Create a new model
     *
     * @param array  Data to create a new object
     * @return boolean
     */
    public function create(array $data)
    {
        $model = $this->repo->create($data);
        $this->cache->flush('Projects', 'Dashboard', 'Tags');
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
        $this->cache->flush('Projects', 'Tags');
        return $bool;
    }


}