<?php namespace TypiCMS\Repositories\Dashboard;

use DB;
use App;
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
		// Build the cache key, unique per model slug
		$key = md5(App::getLocale().'WelcomeMessage');

		if ( $this->cache->has($key) ) {
			d('Welcome message from cache');
			return $this->cache->get($key);
		}

		$message = $this->repo->getWelcomeMessage();

		// Store in cache for next request
		$this->cache->put($key, $message);

		return $message;
	}


	public function getDashboardModules()
	{
		// Build the cache key, unique per model slug
		$key = md5(App::getLocale().'DashboardModules');

		if ( $this->cache->has($key) ) {
			d('Dashboard modules from cache');
			return $this->cache->get($key);
		}

		$modules = $this->repo->getDashboardModules();

		// Store in cache for next request
		$this->cache->put($key, $modules);

		return $modules;
	}

}