<?php namespace TypiCMS\Modules\Menulinks\Repositories;

use App;
use Config;

use TypiCMS\Repositories\CacheAbstractDecorator;
use TypiCMS\Services\Cache\CacheInterface;

class CacheDecorator extends CacheAbstractDecorator implements MenulinkInterface {

	// Class expects a repo and a cache interface
	public function __construct(MenulinkInterface $repo, CacheInterface $cache)
	{
		$this->repo = $repo;
		$this->cache = $cache;
	}

	/**
	 * Get all models
	 *
	 * @param boolean $all Show published or all
     * @return StdClass Object with $items
	 */
	public function getAllFromMenu($all = false, $relid = null)
	{
		$key = md5(App::getLocale().$all.$relid);

		if ( $this->cache->has($key) ) {
			return $this->cache->get($key);
		}

		$models = $this->repo->getAllFromMenu($all, $relid);

		// Store in cache for next request
		$this->cache->put($key, $models);

		return $models;
	}


	/**
	 * Build a menu from its name
	 *
	 * @return Menulinks Collection
	 */
	public function getMenu($name)
	{

		// Build our cache item key, unique per model number,
		$key = md5(App::getLocale().'getMenu'.$name);

		if ( $this->cache->has($key) ) {
			return $this->cache->get($key);
		}

		$models = $this->repo->getMenu($name);

		// Store in cache for next request
		$this->cache->put($key, $models);

		return $models;

	}


	public function getPagesForSelect()
	{
		$array = $this->repo->getPagesForSelect();
		return $array;
	}

}