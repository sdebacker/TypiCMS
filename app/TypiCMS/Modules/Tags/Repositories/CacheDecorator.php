<?php namespace TypiCMS\Modules\Tags\Repositories;

use DB;
use App;

use TypiCMS\Repositories\CacheAbstractDecorator;
use TypiCMS\Services\Cache\CacheInterface;

class CacheDecorator extends CacheAbstractDecorator implements TagInterface {

	// Class expects a repo and a cache interface
	public function __construct(TagInterface $repo, CacheInterface $cache)
	{
		$this->repo = $repo;
		$this->cache = $cache;
	}


	/**
	 * Get tags paginated
	 *
	 * @param boolean $all Show published or all
     * @return StdClass Object with $items
	 */
	public function byPage($paginationPage = 1, $limit = 10, $all = false, $relatedModel = null)
	{
		return $this->repo->byPage($paginationPage, $limit, $all, $relatedModel);
	}


	/**
	 * Get all tags
	 *
	 * @param boolean $all Show published or all
     * @return StdClass Object with $items
	 */
	public function getAll($all = false, $relatedModel = null)
	{
		$key = md5(App::getLocale().'all'.$all.$relatedModel);

		if ( $this->cache->has($key) ) {
			return $this->cache->get($key);
		}

		$models = $this->repo->getAll($all, $relatedModel);

		// Store in cache for next request
		$this->cache->put($key, $models);

		return $models;
	}


	/**
	 * Find existing tags or create if they don't exist
	 *
	 * @param  array $tags  Array of strings, each representing a tag
	 * @return array        Array or Arrayable collection of Tag objects
	 */
	public function findOrCreate(array $tags)
	{
		return $this->repo->findOrCreate($tags);
	}

}