<?php
namespace TypiCMS\Modules\Settings\Repositories;

use TypiCMS\Services\Cache\CacheInterface;

class CacheDecorator implements SettingInterface
{

    public function __construct(SettingInterface $repo, CacheInterface $cache)
    {
        $this->repo = $repo;
        $this->cache = $cache;
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
        $cacheKey = md5('Settings' . implode('.', $with));

        if ($this->cache->has($cacheKey)) {
            return $this->cache->get($cacheKey);
        }

        $data = $this->repo->getAll($with);

        // Store in cache for next request
        $this->cache->put($cacheKey, $data);

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
        $this->cache->flush();
        return $this->repo->store($data);
    }

    /**
     * Build Settings Array
     *
     * @return array
     */
    public function getAllToArray()
    {
        $cacheKey = md5('SettingsToArray');

        if ($this->cache->has($cacheKey)) {
            return $this->cache->get($cacheKey);
        }

        $data = $this->repo->getAllToArray();

        // Store in cache for next request
        $this->cache->put($cacheKey, $data);

        return $data;
    }
}
