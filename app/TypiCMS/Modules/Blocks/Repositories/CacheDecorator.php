<?php
namespace TypiCMS\Modules\Blocks\Repositories;

use App;
use Input;

use TypiCMS\Repositories\CacheAbstractDecorator;
use TypiCMS\Services\Cache\CacheInterface;

class CacheDecorator extends CacheAbstractDecorator implements BlockInterface
{

    // Class expects a repo and a cache interface
    public function __construct(BlockInterface $repo, CacheInterface $cache)
    {
        $this->repo = $repo;
        $this->cache = $cache;
    }
}
