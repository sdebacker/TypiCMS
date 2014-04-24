<?php
namespace TypiCMS\Modules\Categories\Repositories;

use TypiCMS\Repositories\CacheAbstractDecorator;
use TypiCMS\Services\Cache\CacheInterface;

class CacheDecorator extends CacheAbstractDecorator implements CategoryInterface
{

    // Class expects a repo and a cache interface
    public function __construct(CategoryInterface $repo, CacheInterface $cache)
    {
        $this->repo = $repo;
        $this->cache = $cache;
    }

    public function getAllForSelect()
    {
        return $this->repo->getAllForSelect();
    }
}
