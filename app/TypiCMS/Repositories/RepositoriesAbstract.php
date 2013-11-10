<?php namespace TypiCMS\Repositories;

use Config;
use Str;
use DB;
use Cache;
use Schema;
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
		$key = md5($this->model->view.'id.'.$id);

		if ( $this->cache->active('admin') and $this->cache->has($key) ) {
			return $this->cache->get($key);
		}

		// Item not cached, retrieve it
		$model = $this->model->where('id', $id)
			->firstOrFail();

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
		// Build our cache item key, unique per page number,
		// limit and if we're showing all
		$allkey = ($all) ? '.all' : '';
		$key = md5($this->view().'paginationPage.'.$paginationPage.'.'.$limit.$allkey);

		if ( $this->cache->active('admin') and $this->cache->has($key) ) {
			return $this->cache->get($key);
		}

		// Item not cached, retrieve it
		$query = $this->model->with('translations');

		if ($this->model->order and $this->model->direction) {
			$query->orderBy($this->model->order, $this->model->direction);
		}

		// All posts or only published
		if ( ! $all ) {
			$query->where('status', 1);
		}

		$models = $query->skip( $limit * ($paginationPage-1) )
						->take($limit)
						->get();

		// Store in cache for next request
		$cached = $this->cache->putPaginated(
			$paginationPage,
			$limit,
			$this->totalPages($all),
			$models->all(),
			$key
		);

		return $cached;
	}


	/**
	 * Get all models
	 *
	 * @param boolean $all Show published or all
     * @return StdClass Object with $items
	 */
	public function getAll($all = false)
	{
		// Build our cache item key, unique per model number,
		// limit and if we're showing all
		$allkey = ($all) ? '.all' : '';
		$key = md5($this->view().'all'.$allkey);

		if ( $this->cache->active('admin') and $this->cache->has($key) ) {
			return $this->cache->get($key);
		}

		// Item not cached, retrieve it
		$query = $this->model
			->select($this->select)
			->joinTranslations();

		// All posts or only published
		if ( ! $all ) {
			$query->where('status', 1);
		}

		$query->where('lang', Config::get('app.locale'));

		if ($this->model->order and $this->model->direction) {
			$query->orderBy($this->model->order, $this->model->direction);
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
	 * Build html list
	 *
	 * @param array
     * @return string
	 */
	public function buildList(array $array = array())
	{
		$listObject = new ListBuilder($this->listProperties);
		return $listObject->build($array);
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
		$key = md5($this->view().'slug.'.$slug);

		if ( $this->cache->active('admin') and $this->cache->has($key) ) {
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

		// Create the model
		$model = $this->model->create($data);

		if ( ! $model ) {
			return false;
		}

		return true;
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
		$data = array_except($data, '_method');
		$data = array_except($data, '_token');

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
		foreach ($modulesArray as $model => $property) {
			if ($property['menu']) {
				$selectModules[$property['module']] = Str::title(trans_choice('global.modules.'.$property['module'], 2));
			}
		}
		return $selectModules;
	}

	public function getDashboardModules()
	{
		// Build the cache key, unique per model slug
		$key = md5('dashboardmodules');

		if ( $this->cache->active('admin') and $this->cache->has($key) ) {
			return $this->cache->get($key);
		}

		// Item not cached, retrieve it
		$modulesArray = Config::get('app.modules');
		$modules = array();
		foreach ($modulesArray as $module => $property) {
			if ($property['dashboard']) {
				$model = '\\TypiCMS\\Models\\'.$module;
				$model = new $model;
				$table = $model->getTable();
				$modules[$table]['name'] = $table;
				$modules[$table]['route'] = $model->route;
				$modules[$table]['title'] = Str::title(trans_choice('global.modules.'.$table, 2));
				$modules[$table]['count'] = $model->count();
			}
		}

		// Store in cache for next request
		$this->cache->put($key, $modules);

		return $modules;
	}

}