<?php
namespace TypiCMS\Modules\Projects\Repositories;

use TypiCMS\Repositories\CacheAbstractDecorator;
use TypiCMS\Services\Cache\CacheInterface;

class CacheDecorator extends CacheAbstractDecorator implements ProjectInterface
{

    // Class expects a repo and a cache interface
    public function __construct(ProjectInterface $repo, CacheInterface $cache)
    {
        $this->repo = $repo;
        $this->cache = $cache;
    }
}
