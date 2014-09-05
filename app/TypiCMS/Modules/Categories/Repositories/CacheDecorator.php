<?php
namespace TypiCMS\Modules\Categories\Repositories;

use App;
use TypiCMS\Repositories\CacheAbstractDecorator;
use TypiCMS\Services\Cache\CacheInterface;

class CacheDecorator extends CacheAbstractDecorator implements CategoryInterface
{

    public function __construct(CategoryInterface $repo, CacheInterface $cache)
    {
        $this->repo = $repo;
        $this->cache = $cache;
    }

    /**
     * Get all categories for select/option
     *
     * @return array
     */
    public function getAllForSelect()
    {
        return $this->repo->getAllForSelect();
    }

    /**
     * Get all categories and prepare for menu
     *
     * @param  string $uri
     * @return array
     */
    public function getAllForMenu($uri = '')
    {
        $cacheKey = md5(App::getLocale() . 'getAllForMenu' . $uri);

        if ($this->cache->has($cacheKey)) {
            return $this->cache->get($cacheKey);
        }

        // Item not cached, retrieve it
        $models = $this->repo->getAllForMenu($uri);

        // Store in cache for next request
        $this->cache->put($cacheKey, $models);

        return $models;
    }
}
