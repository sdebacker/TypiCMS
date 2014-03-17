<?php
namespace TypiCMS\Modules\Pages\Repositories;

use App;

use TypiCMS\Repositories\CacheAbstractDecorator;
use TypiCMS\Services\Cache\CacheInterface;

class CacheDecorator extends CacheAbstractDecorator implements PageInterface
{

    // Class expects a repo and a cache interface
    public function __construct(PageInterface $repo, CacheInterface $cache)
    {
        $this->repo = $repo;
        $this->cache = $cache;
    }


    /**
     * Get Uris of all pages
     *
     * @return Array[id][lang] = uri
     */
    public function getAllUris()
    {
        return $this->repo->getAllUris();
    }


    /**
     * Retrieve children pages
     *
     * @param  int $id model ID
     * @return Collection
     */
    public function getChildren($uri, $all = false)
    {
        $cacheKey = md5(App::getLocale().'childrenOfId.'.$uri.$all);

        if ( $this->cache->has($cacheKey) ) {
            return $this->cache->get($cacheKey);
        }

        $models = $this->repo->getChildren($uri, $all);

        // Store in cache for next request
        $this->cache->put($cacheKey, $models);

        return $models;
    }


    /**
     * Build html list
     *
     * @param array
     * @return string
     */
    public function buildSideList($models)
    {
        return $this->repo->buildSideList($models);
    }


    /**
     * Get Pages to build routes
     *
     * @return Collection
     */
    public function getForRoutes()
    {
        $cacheKey = md5(App::getLocale().'pagesForRoutes');

        if ( $this->cache->has($cacheKey) ) {
            return $this->cache->get($cacheKey);
        }

        $models = $this->repo->getForRoutes();

        // Store in cache for next request
        $this->cache->put($cacheKey, $models);

        return $models;
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
        $this->cache->flush('Pages', 'Menulinks');
        return $bool;
    }


    /**
     * Update pages uris
     *
     * @param int $id
     * @param $parent
     * @return void
     */
    public function updateUris($id, $parent = null)
    {
        return $this->repo->updateUris($id, $parent);
    }

}
