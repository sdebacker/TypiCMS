<?php
namespace TypiCMS\Modules\Galleries\Repositories;

use App;
use TypiCMS\Repositories\CacheAbstractDecorator;
use TypiCMS\Services\Cache\CacheInterface;

class CacheDecorator extends CacheAbstractDecorator implements GalleryInterface
{

    public function __construct(GalleryInterface $repo, CacheInterface $cache)
    {
        $this->repo = $repo;
        $this->cache = $cache;
    }

    /**
     * Get all items name
     *
     * @return array with names
     */
    public function getNames()
    {
        $cacheKey = md5(App::getLocale() . 'getNames');

        if ($this->cache->has($cacheKey)) {
            return $this->cache->get($cacheKey);
        }

        // Item not cached, retrieve it
        $models = $this->repo->getNames();

        // Store in cache for next request
        $this->cache->put($cacheKey, $models);

        return $models;
    }

    /**
     * Delete model and attached files
     *
     * @return boolean
     */
    public function delete($model)
    {
        $this->cache->flush();
        $this->cache->flush('dashboard');
        return $this->repo->delete($model);
    }
}
