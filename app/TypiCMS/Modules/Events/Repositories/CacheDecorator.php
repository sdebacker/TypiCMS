<?php
namespace TypiCMS\Modules\Events\Repositories;

use App;
use Input;
use TypiCMS\Repositories\CacheAbstractDecorator;
use TypiCMS\Services\Cache\CacheInterface;

class CacheDecorator extends CacheAbstractDecorator implements EventInterface
{

    public function __construct(EventInterface $repo, CacheInterface $cache)
    {
        $this->repo = $repo;
        $this->cache = $cache;
    }

    /**
     * Get incomings events
     *
     * @param  integer      $number number of items to take
     * @param  array        $with array of related items
     * @return Collection
     */
    public function incoming($number = 10, array $with = array('translations'))
    {
        $cacheKey = md5(App::getLocale().'incoming'.$number.implode('.', $with).implode('.', Input::all()));

        if ($this->cache->has($cacheKey)) {
            return $this->cache->get($cacheKey);
        }

        // Item not cached, retrieve it
        $models = $this->repo->incoming($number, $with);

        // Store in cache for next request
        $this->cache->put($cacheKey, $models);

        return $models;
    }
}
