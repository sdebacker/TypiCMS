<?php namespace TypiCMS\Repositories\Page;

use Config;
use DB;
use App;
use Request;

use TypiCMS\Models\PageTranslation;
use TypiCMS\Repositories\RepositoriesAbstract;
use TypiCMS\Services\ListBuilder\ListBuilder;
use TypiCMS\Services\Cache\CacheInterface;
use Illuminate\Database\Eloquent\Model;

class EloquentPage extends RepositoriesAbstract implements PageInterface {

	// Class expects an Eloquent model and a cache interface
	public function __construct(Model $model, CacheInterface $cache)
	{
		$this->model = $model;
		$this->cache = $cache;

		$this->listProperties = array(
			'sortable' => true,
			'nested' => true,
			'display' => array('%s', 'title')
		);

		$this->select = array('pages.id AS id', 'slug', 'uri', 'title', 'status', 'position', 'parent');

	}

	public function getHomePage()
	{
		return $this->model->where('is_home', 1)->firstOrFail();
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

		// update URI in all pages
		$pages = $this->model->orderBy($this->model->order, $this->model->direction)->get();
		foreach ($pages as $key => $page) {
			$this->updateUris($page);
		}

		return true;

	}


	/**
	 * Retrieve children pages
	 *
	 * @param  int $id model ID
	 * @return Collection
	 */
	public function getChildren($uri, $all = false)
	{
		// Build the cache key, unique per model slug
		$key = md5(App::getLocale().$this->view().'childrenOfId.'.$uri);

		if ( Request::segment(1) != 'admin' and $this->cache->active('public') and $this->cache->has($key) ) {
			return $this->cache->get($key);
		}

		// Item not cached, retrieve it
		$rootUriArray = explode('/', $uri);
		$uri = $rootUriArray[0].'/'.$rootUriArray[1];

		$query = $this->model
			->select($this->select)
			->joinTranslations()
			->where('uri', '!=', $uri)
			->where('uri', 'LIKE', $uri.'%');

		// All posts or only published
		if ( ! $all ) {
			$query->where('status', 1);
		}
		$query->where('lang', Config::get('app.locale'));

		if ($this->model->order and $this->model->direction) {
			$query->orderBy($this->model->order, $this->model->direction);
		}

		$models = $query->get();

		$models->nest();

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
		$listObject = new ListBuilder($models);
		return $listObject->sideList();
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

		foreach ($data['item'] as $id => $parent) {
			
			$i++;
			$model = $this->model->find($id);
			$model->position = $i;
			$model->parent = $parent ? $parent : 0 ;
			$model->save();

			$this->updateUris($model);

		}

		return true;

	}

	public function updateUris($model)
	{
		// chercher le parent
		$parentModel = $this->model->find($model->parent);

		// transform URI
		foreach (Config::get('app.locales') as $locale) {
			
			if (isset($model->$locale->slug) and $model->$locale->slug) {

				$uri = ($parentModel) ? $parentModel->$locale->uri.'/'.$model->$locale->slug : $locale.'/'.$model->$locale->slug ;

				DB::table('pages_translations')->where('page_id', '=', $model->id)->where('lang', '=', $locale)->update(array('uri' => $uri));

			}

		}
	}

}