<?php
namespace TypiCMS\Modules\Dashboard\Repositories;

use App;
use TypiCMS\Repositories\CacheAbstractDecorator;
use TypiCMS\Services\Cache\CacheInterface;

class CacheDecorator extends CacheAbstractDecorator implements DashboardInterface
{

    public function __construct(DashboardInterface $repo, CacheInterface $cache)
    {
        $this->repo = $repo;
        $this->cache = $cache;
    }

    public function getWelcomeMessage()
    {
        // Build the cache key, unique per model slug
        $cacheKey = md5(App::getLocale().'WelcomeMessage');

        if ($this->cache->has($cacheKey)) {
            return $this->cache->get($cacheKey);
        }

        $message = $this->repo->getWelcomeMessage();

        // Store in cache for next request
        $this->cache->put($cacheKey, $message);

        return $message;
    }
}
