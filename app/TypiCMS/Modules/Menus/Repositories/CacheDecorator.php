<?php namespace TypiCMS\Modules\Menus\Repositories;

use TypiCMS\Repositories\CacheAbstractDecorator;
use TypiCMS\Services\Cache\CacheInterface;

class CacheDecorator extends CacheAbstractDecorator implements MenuInterface {

	// Class expects a repo and a cache interface
	public function __construct(MenuInterface $repo, CacheInterface $cache)
	{
		$this->repo = $repo;
		$this->cache = $cache;
	}


}