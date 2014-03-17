<?php namespace TypiCMS\Modules\Settings\Repositories;

use stdClass;

use TypiCMS\Repositories\CacheAbstractDecorator;
use TypiCMS\Services\Cache\CacheInterface;

class CacheDecorator extends CacheAbstractDecorator implements SettingInterface
{

    // Class expects a repo and a cache interface
    public function __construct(SettingInterface $repo, CacheInterface $cache)
    {
        $this->repo = $repo;
        $this->cache = $cache;
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
        $key = md5('Settings');

        if ( $this->cache->has($key) ) {
            return $this->cache->get($key);
        }

        $data = $this->repo->getAll($with);

        // Store in cache for next request
        $this->cache->put($key, $data);

        return $data;
    }


    /**
     * Update an existing model
     *
     * @param array  Data to update a model
     * @return boolean
     */
    public function store(array $data)
    {
        $bool = $this->repo->store($data);
        $this->cache->flush();
        return $bool;
    }


    /**
     * Build Settings Array
     *
     * @return array
     */
    public function getAllToArray()
    {
        $key = md5('SettingsToArray');

        if ( $this->cache->has($key) ) {
            return $this->cache->get($key);
        }

        $data = $this->repo->getAllToArray();

        // Store in cache for next request
        $this->cache->put($key, $data);

        return $data;
    }

}