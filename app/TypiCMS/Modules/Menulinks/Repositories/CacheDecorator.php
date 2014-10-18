<?php
namespace TypiCMS\Modules\Menulinks\Repositories;

use App;
use TypiCMS\Repositories\CacheAbstractDecorator;
use TypiCMS\Services\Cache\CacheInterface;

class CacheDecorator extends CacheAbstractDecorator implements MenulinkInterface
{

    public function __construct(MenulinkInterface $repo, CacheInterface $cache)
    {
        $this->repo = $repo;
        $this->cache = $cache;
    }

    /**
     * Get Items to build routes
     *
     * @return Array
     */
    public function getForRoutes()
    {
        $cacheKey = md5(App::getLocale().'menulinksForRoutes');

        if ($this->cache->has($cacheKey)) {
            return $this->cache->get($cacheKey);
        }

        $models = $this->repo->getForRoutes();

        // Store in cache for next request
        $this->cache->put($cacheKey, $models);

        return $models;
    }
}
