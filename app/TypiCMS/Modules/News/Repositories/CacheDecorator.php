<?php namespace TypiCMS\Modules\News\Repositories;

use TypiCMS\Repositories\CacheAbstractDecorator;
use TypiCMS\Services\Cache\CacheInterface;

class CacheDecorator extends CacheAbstractDecorator implements NewsInterface
{

    // Class expects a repo and a cache interface
    public function __construct(NewsInterface $repo, CacheInterface $cache)
    {
        $this->repo = $repo;
        $this->cache = $cache;
    }


}