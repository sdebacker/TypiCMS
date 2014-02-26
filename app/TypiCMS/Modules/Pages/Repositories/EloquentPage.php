<?php namespace TypiCMS\Modules\Pages\Repositories;

use DB;
use App;
use Config;

use Illuminate\Database\Eloquent\Model;

use TypiCMS\Services\ListBuilder\ListBuilder;
use TypiCMS\Repositories\RepositoriesAbstract;
use TypiCMS\Modules\Pages\Models\PageTranslation;

class EloquentPage extends RepositoriesAbstract implements PageInterface {

	protected $uris = array();

	// Class expects an Eloquent model
	public function __construct(Model $model)
	{
		$this->model = $model;
	}


	public function getHomePage()
	{
		return $this->model->where('is_home', 1)->first();
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
		$pages = $this->model->order()->get();
		$this->uris = $this->getAllUris();
		foreach ($pages as $key => $page) {
			$this->updateUris($page->id, $page->parent);
		}

		return true;

	}


	/**
	 * Get Uris of all pages
	 *
	 * @return Array[id][lang] = uri
	 */
	public function getAllUris()
	{
		// Build uris array of all pages (needed for uris updating after sorting)
		$pages = DB::table('page_translations')->select('page_id', 'locale', 'uri')->get();
		foreach ($pages as $page) {
			$this->uris[$page->page_id][$page->locale] = $page->uri;
		}
	}

	/**
	 * Retrieve children pages
	 *
	 * @param  int $id model ID
	 * @return Collection
	 */
	public function getChildren($uri, $all = false)
	{
		$rootUriArray = explode('/', $uri);
		$uri = $rootUriArray[0].'/'.$rootUriArray[1];

		$query = $this->model
			->with('translations')
			->select(
				array(
					'pages.id AS id',
					'slug',
					'uri',
					'title',
					'status',
					'position',
					'parent'
				)
			)
			->join('page_translations', 'pages.id', '=', 'page_translations.page_id')
			->where('uri', '!=', $uri)
			->where('uri', 'LIKE', $uri.'%');

		// All posts or only published
		if ( ! $all ) {
			$query->where('status', 1);
		}
		$query->where('locale', Config::get('app.locale'));

		$query->order();

		$models = $query->get();

		$models->nest();

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

		$this->uris = $this->getAllUris();
		foreach ($data['item'] as $id => $parent) {
			
			$position ++;

			$parent = $parent ? : 0 ;

			$this->model->find($id)
				->update(array('position' => $position, 'parent' => $parent));

			$this->updateUris($id, $parent);

		}

		return true;

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

		// model slugs
		$modelSlugs = DB::table('page_translations')->where('page_id', $id)->lists('slug', 'locale');

		// parent uris
		$parentUris = DB::table('page_translations')->where('page_id', $parent)->lists('uri', 'locale');

		// transform URI
		foreach (Config::get('app.locales') as $locale) {
			
			if (isset($modelSlugs[$locale])) {

				$uri = isset($parentUris[$locale]) ? $parentUris[$locale].'/'.$modelSlugs[$locale] : $locale.'/'.$modelSlugs[$locale] ;

				// Check uri is unique
				$tmpUri = $uri;
				$i = 0;
				while (DB::table('page_translations')->where('uri', $tmpUri)->where('page_id', '!=', $id)->first()) {
					$i ++;
					// increment uri if exists
					$tmpUri = $uri.'-'.$i;
				}
				$uri = $tmpUri;

				// update uri if needed
				if ($uri != $this->uris[$id][$locale]) {
					DB::table('page_translations')
						->where('page_id', '=', $id)
						->where('locale', '=', $locale)
						->update(array('uri' => $uri));
				}

			}

		}
	}

}
