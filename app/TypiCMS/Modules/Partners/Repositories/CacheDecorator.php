<?php
namespace TypiCMS\Modules\Partners\Repositories;

use App;
use Input;

use TypiCMS\Repositories\CacheAbstractDecorator;
use TypiCMS\Services\Cache\CacheInterface;

class CacheDecorator extends CacheAbstractDecorator implements PartnerInterface
{

    // Class expects a repo and a cache interface
    public function __construct(PartnerInterface $repo, CacheInterface $cache)
    {
        $this->repo = $repo;
        $this->cache = $cache;
    }
}
