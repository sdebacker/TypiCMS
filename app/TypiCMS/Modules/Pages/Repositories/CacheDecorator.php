<?php namespace TypiCMS\Modules\Pages\Repositories;

use App;

use TypiCMS\Repositories\CacheAbstractDecorator;
use TypiCMS\Services\Cache\CacheInterface;

class CacheDecorator extends CacheAbstractDecorator implements PageInterface {

	// Class expects a repo and a cache interface
	public function __construct(PageInterface $repo, CacheInterface $cache)
	{
		$this->repo = $repo;
		$this->cache = $cache;
	}


	/**
	 * Get Homepage
	 *
	 * @return TypiCMS\Modules\Pages\Models\Page
	 */
	public function getHomePage()
	{
		// Build the cache key, unique per model slug
		$key = md5(App::getLocale().'homepage.');

		if ( $this->cache->has($key) ) {
			return $this->cache->get($key);
		}

		$model = $this->repo->getHomePage();

		// Store in cache for next request
		$this->cache->put($key, $model);

		return $model;
	}


	/**
	 * Update an existing model
	 *
	 * @param array  Data to update a model
	 * @return boolean
	 */
	public function update(array $data)
	{
		return $this->repo->update($data);
	}


	/**
	 * Get Uris of all pages
	 *
	 * @return Array[id][lang] = uri
	 */
	public function getAllUris()
	{
		return $this->repo->getAllUris();
	}


	/**
	 * Retrieve children pages
	 *
	 * @param  int $id model ID
	 * @return Collection
	 */
	public function getChildren($uri, $all = false)
	{
		$key = md5(App::getLocale().'childrenOfId.'.$uri.$all);

		if ( $this->cache->has($key) ) {
			return $this->cache->get($key);
		}

		$models = $this->repo->getChildren($uri, $all);

		// Store in cache for next request
		$this->cache->put($key, $models);

		return $models;
	}


	/**
	 * Build html list
	 *
	 * @param array
	 * @return string
	 */
	public function buildSideList($models)
	{
		return $this->repo->buildSideList($models);
	}


	/**
	 * Sort models
	 *
	 * @param array  Data to update Pages
	 * @return boolean
	 */
	public function sort(array $data)
	{
		return $this->repo->sort($data);
	}


	/**
	 * Update pages uris
	 *
	 * @param int $id
	 * @param $parent
	 * @return void
	 */
	public function updateUris($id, $parent = null)
	{
		return $this->repo->updateUris($id, $parent);
	}

}
