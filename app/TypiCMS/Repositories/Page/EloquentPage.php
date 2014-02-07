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

	protected $uris = array();

	// Class expects an Eloquent model and a cache interface
	public function __construct(Model $model, CacheInterface $cache)
	{
		$this->model = $model;
		$this->cache = $cache;

		// Build uris array of all pages (needed for uris updating after sorting)
		$pages = DB::table('pages_translations')->select('page_id', 'lang', 'uri')->get();
		foreach ($pages as $page) {
			$this->uris[$page->page_id][$page->lang] = $page->uri;
		}

		$this->listProperties = array(
			'sortable' => true,
			'nested' => true,
			'display' => array('%s', 'title')
		);

		$this->select = array(
			'pages.id AS id',
			'slug',
			'uri',
			'title',
			'status',
			'position',
			'parent'
		);

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
		$model->fill($data);
		$model->save();

		// update URI in all pages
		$pages = $this->model->orderBy($this->model->order, $this->model->direction)->get();
		foreach ($pages as $key => $page) {
			$this->updateUris($page->id, $page->parent);
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
		$key = md5(App::getLocale().'childrenOfId.'.$uri);

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

		$position = 0;

		foreach ($data['item'] as $id => $parent) {
			
			$position ++;

			$parent = $parent ? : 0 ;

			DB::table('pages')
				->where('id', $id)
				->update(array('position' => $position, 'parent' => $parent));

			$this->updateUris($id, $parent);

		}

		return true;

	}

	public function updateUris($id, $parent = null)
	{

		// model slugs
		$modelSlugs = DB::table('pages_translations')->where('page_id', $id)->lists('slug', 'lang');

		// parent uris
		$parentUris = DB::table('pages_translations')->where('page_id', $parent)->lists('uri', 'lang');

		// transform URI
		foreach (Config::get('app.locales') as $locale) {
			
			if (isset($modelSlugs[$locale])) {

				$uri = isset($parentUris[$locale]) ? $parentUris[$locale].'/'.$modelSlugs[$locale] : $locale.'/'.$modelSlugs[$locale] ;

				// Check uri is unique
				$tmpUri = $uri;
				$i = 0;
				while (DB::table('pages_translations')->where('uri', $tmpUri)->where('page_id', '!=', $id)->first()) {
					$i ++;
					// increment uri if exists
					$tmpUri = $uri.'-'.$i;
				}
				$uri = $tmpUri;

				// update uri if needed
				if ($uri != $this->uris[$id][$locale]) {
					DB::table('pages_translations')
						->where('page_id', '=', $id)
						->where('lang', '=', $locale)
						->update(array('uri' => $uri));
				}

			}

		}
	}

}
