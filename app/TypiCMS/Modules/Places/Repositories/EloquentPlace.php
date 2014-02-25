<?php namespace TypiCMS\Modules\Places\Repositories;

use TypiCMS\Repositories\RepositoriesAbstract;
use TypiCMS\Services\Cache\CacheInterface;

use Illuminate\Database\Eloquent\Model;

use Config;
use Input;
use App;
use Request;

class EloquentPlace extends RepositoriesAbstract implements PlaceInterface {

	// Class expects an Eloquent model and a cache interface
	public function __construct(Model $model, CacheInterface $cache)
	{
		$this->model = $model;
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
		$query = $this->model
			->select('places.*', 'status')
			->with('translations')
			->join('place_translations', 'place_translations.place_id', '=', 'places.id')
			->where('locale', App::getLocale());

		! $all and $query->where('status', 1);

		$query->order();

		$models = $query->paginate($limit);

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
		$string = Input::get('string');

		// Item not cached, retrieve it

		$query = $this->model->with('translations');

		if ( ! $all ) {
			// take only translated items that are online
			$query->whereHas('translations', function($query)
				{
					$query->where('status', 1);
					$query->where('locale', '=', App::getLocale());
				}
			);
		}

		if (Request::wantsJson()) { // pour affichage sur la carte
			$query->where('latitude', '!=', '');
			$query->where('longitude', '!=', '');
		}

		$string and $query->where('title', 'LIKE', '%'.$string.'%');

		$query->order();

		$models = $query->get();

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
		// Build the cache key, unique per model slug
		$key = md5(App::getLocale().'slug.'.$slug);

		if ( Request::segment(1) != 'admin' and $this->cache->active('public') and $this->cache->has($key) ) {
			return $this->cache->get($key);
		}

		// Item not cached, retrieve it
		$model = $this->model->with('translations')
			->where('slug', $slug)
			->where('status', 1)
			->firstOrFail();

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
		// Create the model
		$model = $this->model;

		$data = array_except($data, array('exit'));

		$model->fill($data);

		if (Input::hasFile('logo')) {
			$model->logo = $this->upload(Input::file('logo'));
		}

		if (Input::hasFile('image')) {
			$model->image = $this->upload(Input::file('image'));
		}

		$model->save();

		if ( ! $model ) {
			return false;
		}

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

		$model = $this->model->find($data['id']);

		$data = array_except($data, array('exit'));
		$model->fill($data);

		if (Input::hasFile('logo')) {
			// delete prev logo
			Croppa::delete('/uploads/'.$this->model->getTable().'/'.$model->getOriginal('logo'));
			$model->logo = $this->upload(Input::file('logo'));
		} else {
			$model->logo = $model->getOriginal('logo');
		}

		if (Input::hasFile('image')) {
			// delete prev image
			Croppa::delete('/uploads/'.$this->model->table.'/'.$model->getOriginal('image'));
			$model->image = $this->upload(Input::file('image'));
		} else {
			$model->image = $model->getOriginal('image');
		}

		$model->save();

		return true;
		
	}


}