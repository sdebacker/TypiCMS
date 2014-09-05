<?php
namespace TypiCMS\Modules\Menus\Repositories;

use App;
use TypiCMS\Repositories\CacheAbstractDecorator;
use TypiCMS\Services\Cache\CacheInterface;

class CacheDecorator extends CacheAbstractDecorator implements MenuInterface
{

    public function __construct(MenuInterface $repo, CacheInterface $cache)
    {
        $this->repo = $repo;
        $this->cache = $cache;
    }

    /**
     * Get all menus
     *
     * @return array with key = menu name and value = menu model
     */
    public function getAllMenus()
    {
        $cacheKey = md5(App::getLocale() . 'getAllMenus');

        if ($this->cache->has($cacheKey)) {
            return $this->cache->get($cacheKey);
        }

        $array = $this->repo->getAllMenus();

        // Store in cache for next request
        $this->cache->put($cacheKey, $array);

        return $array;
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

    /**
     * Get a menu
     *
     * @param  string $name       menu name
     * @return Collection         nested collection
     */
    public function getMenu($name)
    {
        return $this->repo->getMenu($name);
    }
}
