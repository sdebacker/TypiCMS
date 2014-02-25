<?php namespace TypiCMS\Repositories\Dashboard;

use DB;
use Str;
use Sentry;
use Config;

use TypiCMS\Repositories\CacheAbstractDecorator;
use TypiCMS\Services\Cache\CacheInterface;

class CacheDecorator extends CacheAbstractDecorator implements DashboardInterface {

	// Class expects a repo and a cache interface
	public function __construct(DashboardInterface $repo, CacheInterface $cache)
	{
		$this->repo = $repo;
		$this->cache = $cache;
	}

	public function getWelcomeMessage()
	{
		return $this->repo->getWelcomeMessage();
	}


	public function getDashboardModules()
	{
		return $this->repo->getDashboardModules();
	}

}