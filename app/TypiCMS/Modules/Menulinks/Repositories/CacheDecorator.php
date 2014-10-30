<?php
namespace TypiCMS\Modules\Menulinks\Repositories;

use App;
use Illuminate\Database\Eloquent\Collection;
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
     * Get a menu’s items and children
     *
     * @param  integer  $id
     * @param  boolean  $all published or all
     * @return Collection
     */
    public function getAllFromMenu($id = null, $all = false)
    {
        $cacheKey = md5(App::getLocale().'all'.$all.$id);

        if ($this->cache->has($cacheKey)) {
            return $this->cache->get($cacheKey);
        }

        $models = $this->repo->getAllFromMenu($id, $all);

        // Store in cache for next request
        $this->cache->put($cacheKey, $models);

        return $models;
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
