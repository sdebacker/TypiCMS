<?php namespace TypiCMS\Repositories;

use Config;
use App;
use Str;
use Request;
use TypiCMS\Services\ListBuilder\ListBuilder;

abstract class RepositoriesAbstract {

	protected $model;
	protected $cache;
	protected $listProperties = array();


	public function view()
	{
		return $this->model->view;
	}

	public function route()
	{
		return $this->model->route;
	}

	public function getModel()
	{
		return $this->model;
	}

	/**
	 * Retrieve model by id
	 * regardless of status
	 *
	 * @param  int $id model ID
	 * @return stdObject object of model information
	 */
	public function byId($id)
	{
		// Build the cache key, unique per model slug
		$key = md5(App::getLocale().'id.'.$id);

		if ( Request::segment(1) != 'admin' and $this->cache->active('public') and $this->cache->has($key) ) {
			return $this->cache->get($key);
		}

		// Item not cached, retrieve it
		$query = $this->model->where('id', $id);

		// files
		$this->model->files and $query->with(array('files' => function($query)
			{
				$query->joinTranslations();
				$query->where('lang', Config::get('app.locale'));
				$query->where('status', 1);
				$query->orderBy('position', 'asc');
			})
		);

		$model = $query->firstOrFail();

		// Store in cache for next request
		$this->cache->put($key, $model);

		return $model;
	}


	/**
	 * Get paginated pages
	 *
	 * @param int $paginationPage Number of pages per page
	 * @param int $limit Results per page
	 * @param boolean $all Show published or all
	 * @return StdClass Object with $items and $totalItems for pagination
	 */
	public function byPage($paginationPage = 1, $limit = 10, $all = false)
	{
		// All posts or only published
		$translations = 'translations';
		if ( ! $all ) {
			$translations = array('translations' => function($query)
			{
				$query->where('status', 1);
			});
		}

		$query = $this->model->with($translations);

		// files
		$this->model->files and $query->with('files');

		// order
		$order = $this->model->order ? : 'id' ;
		$direction = $this->model->direction ? : 'ASC' ;
		$query->orderBy($order, $direction);

		$models = $query->paginate($limit);

		return $models;
	}


	/**
	 * Get all models
	 *
	 * @param boolean $all Show published or all
     * @return StdClass Object with $items
	 */
	public function getAll($all = false, $relatedModel = null)
	{
		// Build our cache item key, unique per model number,
		// limit and if we're showing all
		$allkey = ($all) ? '.all' : '';
		$key = md5(App::getLocale().'all'.$allkey);

		if ( Request::segment(1) != 'admin' and $this->cache->active('public') and $this->cache->has($key) ) {
			return $this->cache->get($key);
		}

		// Item not cached, retrieve it

		// All posts or only published
		$translations = 'translations';
		if ( ! $all ) {
			$translations = array('translations' => function($query)
			{
				$query->where('status', 1);
			});
		}

		$query = $this->model->with($translations);

		if ($relatedModel) {
			$query->where('fileable_id', $relatedModel->id);
			$query->where('fileable_type', get_class($relatedModel));
		}

		// files
		$this->model->files and $query->with('files');

		// order
		$order = $this->model->order ? : 'id' ;
		$direction = $this->model->direction ? : 'ASC' ;
		$query->orderBy($order, $direction);

		$models = $query->get();

		// Filter : Delete models without translations (translation is offline for example)
		if ( ! $all ) {
			$models = $models->filter(function($model)
			{
				if (count($model->translations)) {
					return $model;
				}
			});
		}

		if (property_exists($this->model, 'children')) {
			$models->nest();
		}

		// Store in cache for next request
		$this->cache->put($key, $models);

		return $models;
	}


	/**
	 * Return properties for lists
	 *
     * @return array
	 */
	public function getListProperties()
	{
		return $this->listProperties;
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
			->with(array('files' => function($query)
				{
					$query->joinTranslations();
					$query->where('lang', Config::get('app.locale'));
					$query->where('status', 1);
					$query->orderBy('position', 'asc');
				})
			)
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
		$data = array_except($data, Config::get('app.locales'));
		$data = array_except($data, array('exit'));

		// Create the model
		$model = $this->model->create($data);

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

		$model->save();

		return true;
		
	}

    /**
     * Make a string "slug-friendly" for URLs
     * @param  string $string  Human-friendly tag
     * @return string       Computer-friendly tag
     */
    protected function slug($string)
    {
        return filter_var( str_replace(' ', '-', strtolower( trim($string) ) ), FILTER_SANITIZE_URL);
    }


	/**
	 * Get total model count
	 *
	 * @return int  Total models
	 */
	protected function total($all = false)
	{
		if ( ! $all ) {
			return $this->model->where('status', 1)->count();
		}

		return $this->model->count();
	}


	/**
	 * Sort models
	 *
	 * @param array  Data to update Pages
	 * @return boolean
	 */
	public function sort(array $data)
	{
		$i = 0;

		if (isset($data['nested']) and $data['nested']) {

			foreach ($data['item'] as $id => $parent) {
				
				$i++;
				$model = $this->model->find($id);
				$model->position = $i;
				$model->parent = $parent ? $parent : 0 ;
				$model->save();

			}

		} else {

			foreach ($data['item'] as $key => $id) {
				
				$model = $this->model->find($id);
				$model->position = $key+1;
				$model->save();

			}

		}

		return true;

	}


	public function getModulesForSelect()
	{
		$modulesArray = Config::get('app.modules');
		$selectModules = array('' => '');
		foreach ($modulesArray as $module => $property) {
			if ($property['menu']) {
				$selectModules[strtolower($module)] = Str::title(trans_choice('modules.'.strtolower($module.'.'.$module), 2));
			}
		}
		return $selectModules;
	}


}