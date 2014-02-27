<?php namespace TypiCMS\Modules\Places\Repositories;

use App;
use Input;

use TypiCMS\Repositories\CacheAbstractDecorator;
use TypiCMS\Services\Cache\CacheInterface;

class CacheDecorator extends CacheAbstractDecorator implements PlaceInterface {

	// Class expects a repo and a cache interface
	public function __construct(PlaceInterface $repo, CacheInterface $cache)
	{
		$this->repo = $repo;
		$this->cache = $cache;
	}


	/**
	 * Get paginated pages
	 *
	 * @param int $page Number of pages per page
	 * @param int $limit Results per page
	 * @param boolean $all Show published or all
	 * @return StdClass Object with $items and $totalItems for pagination
	 */
	public function byPage($page = 1, $limit = 10, $all = false, $relatedModel = null)
	{
		$key = md5(App::getLocale().'byPage.'.$page.$limit.$all.$relatedModel.implode(Input::except('page')));

		if ( $this->cache->has($key) ) {
			return $this->cache->get($key);
		}

		$models = $this->repo->byPage($page, $limit, $all, $relatedModel);

		// Store in cache for next request
		$this->cache->put($key, $models);

		return $models;
	}


	/**
	 * Get all models
	 *
	 * @param boolean $all Show published or all
     * @return StdClass Object with $items
	 */
	public function getAll($all = false, $category_id = null)
	{
		// get search string
		$string = Input::get('string');

		$key = md5(App::getLocale().'all'.$all.$category_id.$string);

		if ( $this->cache->has($key) ) {
			return $this->cache->get($key);
		}

		$models = $this->repo->getAll($all, $category_id);

		// Store in cache for next request
		$this->cache->put($key, $models);

		return $models;
	}


	/**
	 * Get single model by URL
	 *
	 * @param string  URL slug of model
	 * @return object object of model information
	 */
	public function bySlug($slug)
	{
		$key = md5(App::getLocale().'slug.'.$slug);

		if ( $this->cache->has($key) ) {
			return $this->cache->get($key);
		}

		$model = $this->repo->bySlug($slug);

		// Store in cache for next request
		$this->cache->put($key, $model);

		return $model;

	}


	/**
	 * Create a new model
	 *
	 * @param array  Data to create a new object
	 * @return boolean
	 */
	public function create(array $data)
	{
		$model = $this->repo->create($data);
		$this->cache->flush('Places', 'Dashboard');
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
		$bool = $this->repo->update($data);
		$this->cache->flush();
		return $bool;
	}


}