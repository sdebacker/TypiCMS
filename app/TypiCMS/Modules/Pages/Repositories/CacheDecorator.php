<?php
namespace TypiCMS\Modules\Pages\Repositories;

use App;
use Input;
use TypiCMS\Repositories\CacheAbstractDecorator;
use TypiCMS\Services\Cache\CacheInterface;

class CacheDecorator extends CacheAbstractDecorator implements PageInterface
{

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
     * Get page by uri
     *
     * @param  string                      $uri
     * @return TypiCMS\Modules\Models\Page $model
     */
    public function getFirstByUri($uri)
    {
        $cacheKey = md5(App::getLocale().'getFirstByUri.'.$uri.implode('.', Input::all()));

        if ($this->cache->has($cacheKey)) {
            return $this->cache->get($cacheKey);
        }

        $model = $this->repo->getFirstByUri($uri);

        // Store in cache for next request
        $this->cache->put($cacheKey, $model);

        return $model;
    }


    /**
     * Retrieve children pages
     *
     * @return Collection
     */
    public function getChildren($uri, $all = false)
    {
        $cacheKey = md5(App::getLocale().'childrenOfId.'.$uri.$all);

        if ($this->cache->has($cacheKey)) {
            return $this->cache->get($cacheKey);
        }

        $models = $this->repo->getChildren($uri, $all);

        // Store in cache for next request
        $this->cache->put($cacheKey, $models);

        return $models;
    }

    /**
     * Get Pages to build routes
     *
     * @return Collection
     */
    public function getForRoutes()
    {
        $cacheKey = md5(App::getLocale().'pagesForRoutes');

        if ($this->cache->has($cacheKey)) {
            return $this->cache->get($cacheKey);
        }

        $models = $this->repo->getForRoutes();

        // Store in cache for next request
        $this->cache->put($cacheKey, $models);

        return $models;
    }

    /**
     * Update pages uris
     *
     * @param  int  $id
     * @param $parent
     * @return void
     */
    public function updateUris($id, $parent = null)
    {
        return $this->repo->updateUris($id, $parent);
    }
}
