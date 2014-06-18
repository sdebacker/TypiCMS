<?php
namespace TypiCMS\Modules\Menus\Repositories;

use App;

use TypiCMS\Repositories\CacheAbstractDecorator;
use TypiCMS\Services\Cache\CacheInterface;

class CacheDecorator extends CacheAbstractDecorator implements MenuInterface
{

    // Class expects a repo and a cache interface
    public function __construct(MenuInterface $repo, CacheInterface $cache)
    {
        $this->repo = $repo;
        $this->cache = $cache;
    }

    /**
     * Get a menu by its name for public side
     * 
     * @param  string $name menu name
     * @return Model
     */
    public function getByName($name)
    {
        $cacheKey = md5(App::getLocale() . 'build' . $name);

        if ($this->cache->has($cacheKey)) {
            return $this->cache->get($cacheKey);
        }

        $models = $this->repo->getByName($name);

        // Store in cache for next request
        $this->cache->put($cacheKey, $models);

        return $models;
    }

    /**
     * Build a menu
     * 
     * @param  string $name       menu name
     * @return string             html code of a menu
     */
    public function build($name)
    {
        return $this->repo->build($name);
    }
}
