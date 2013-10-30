<?php namespace TypiCMS\Repositories\Dashboard;

use Config;
use DB;

use TypiCMS\Repositories\RepositoriesAbstract;
use TypiCMS\Services\Cache\CacheInterface;

class EloquentDashboard extends RepositoriesAbstract implements DashboardInterface {

	// Class expects an Eloquent model and a cache interface
	public function __construct(CacheInterface $cache)
	{
		$this->cache = $cache;
	}

}