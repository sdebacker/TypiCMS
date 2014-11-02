<?php
namespace TypiCMS\Modules\Translations\Repositories;

use App;
use TypiCMS\Repositories\CacheAbstractDecorator;
use TypiCMS\Services\Cache\CacheInterface;

class CacheDecorator extends CacheAbstractDecorator implements TranslationInterface
{

    public function __construct(TranslationInterface $repo, CacheInterface $cache)
    {
        $this->repo = $repo;
        $this->cache = $cache;
    }

    /**
     * Get translations to Array
     *
     * @return array
     */
    public function getAllToArray($locale, $group, $namespace = null)
    {
        $cacheKey = md5(App::getLocale().'TranslationsToArray');

        if ($this->cache->has($cacheKey)) {
            return $this->cache->get($cacheKey);
        }

        $data = $this->repo->getAllToArray($locale, $group, $namespace);

        // Store in cache for next request
        $this->cache->put($cacheKey, $data);

        return $data;
    }
}
