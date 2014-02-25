<?php namespace TypiCMS\Repositories\Setting;

use stdClass;

use TypiCMS\Repositories\CacheAbstractDecorator;
use TypiCMS\Services\Cache\CacheInterface;

class CacheDecorator extends CacheAbstractDecorator implements SettingInterface {

	// Class expects a repo and a cache interface
	public function __construct(SettingInterface $repo, CacheInterface $cache)
	{
		$this->repo = $repo;
		$this->cache = $cache;
	}


	/**
	 * Get all models
	 *
     * @return StdClass Object with $items
	 */
	public function getAll()
	{
		$key = md5('Settings');

		if ( $this->cache->has($key) ) {
			return $this->cache->get($key);
		}

		$data = $this->repo->getAll();

		// Store in cache for next request
		$this->cache->put($key, $data);

		return $data;
	}


	/**
	 * Update an existing model
	 *
	 * @param array  Data to update a model
	 * @return boolean
	 */
	public function store(array $data)
	{
		$data = $this->repo->store($data);
		return $data;	
	}

}