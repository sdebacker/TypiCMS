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

		$this->listProperties = array(
			'display' => array('%s', 'title'),
		);

		$this->select = array(
			'places.id AS id',
			'slug',
			'title',
			'address',
			'email',
			'phone',
			'fax',
			'website',
			'info',
			'logo',
			'image',
			'status',
			'latitude',
			'longitude',
			'position',
		);

	}


	/**
	 * Get all models
	 *
	 * @param boolean $all Show published or all
     * @return StdClass Object with $items
	 */
	public function getAll($all = false, $category_id = null)
	{
		// Build our cache item key, unique per model number,
		// limit and if we're showing all
		$allkey = ($all) ? '.all' : '';
		$allkey .= $category_id;
		if (Request::wantsJson()) { // pour affichage sur la carte
			$allkey .= 'Json';
		}
		$key = md5(App::getLocale().'all'.$allkey);

		if ( Request::segment(1) != 'admin' and $this->cache->active('public') and $this->cache->has($key) ) {
			return $this->cache->get($key);
		}

		// Item not cached, retrieve it
		$query = $this->model
			->select($this->select)
			->joinTranslations();

		if ($category_id) {
			$this->listProperties['sortable'] = true;
			$query->where('category_id', $category_id);
		}

		if (Request::wantsJson()) { // pour affichage sur la carte
			$query->where('latitude', '!=', '');
			$query->where('longitude', '!=', '');
		}

		// All posts or only published
		if ( ! $all ) {
			$query->where('status', 1);
		}

		$query->where('lang', Config::get('app.locale'));

		if ($category_id) {
			$query->orderBy('position');
		} else {
			$query->orderBy('title');
		}

		$models = $query->get();

		if (property_exists($this->model, 'children')) {
			$models->nest();
		}

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
		// Build the cache key, unique per model slug
		$key = md5(App::getLocale().'slug.'.$slug);

		if ( Request::segment(1) != 'admin' and $this->cache->active('public') and $this->cache->has($key) ) {
			return $this->cache->get($key);
		}

		// Item not cached, retrieve it
		$model = $this->model
			->select($this->select)
			->joinTranslations()
			->where('slug', $slug)
			->where('status', 1)
			->where('lang', Config::get('app.locale'))
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

		$data = array_except($data, Config::get('app.locales'));
		$data = array_except($data, array('_method', '_token', 'exit'));

		foreach ($data as $key => $value) {
			$model->$key = $value;
		}

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

		$data = array_except($data, Config::get('app.locales'));
		$data = array_except($data, array('_method', '_token', 'exit'));

		foreach ($data as $key => $value) {
			$model->$key = $value;
		}

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