<?php
namespace TypiCMS\Modules\Blocks\Repositories;

use App;
use TypiCMS\Repositories\CacheAbstractDecorator;
use TypiCMS\Services\Cache\CacheInterface;

class CacheDecorator extends CacheAbstractDecorator implements BlockInterface
{

    public function __construct(BlockInterface $repo, CacheInterface $cache)
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
        $cacheKey = md5(App::getLocale() . 'all' . $all . implode('.', $with));

        if ($this->cache->has($cacheKey)) {
            return $this->cache->get($cacheKey);
        }

        // Item not cached, retrieve it
        $models = $this->repo->getAll($with, $all);

        // Store in cache for next request
        $this->cache->put($cacheKey, $models);

        return $models;
    }

    /**
     * Get the content of a block
     *
     * @param  string $name unique name of the block
     * @param  array  $with linked
     * @return string       html
     */
    public function build($name = null, array $with = array('translations'))
    {
        $cacheKey = md5(App::getLocale() . 'build' . $name . implode('.', $with));

        if ($this->cache->has($cacheKey)) {
            return $this->cache->get($cacheKey);
        }

        // Item not cached, retrieve it
        $model = $this->repo->build($name, $with);

        // Store in cache for next request
        $this->cache->put($cacheKey, $model);

        return $model;
    }
}
