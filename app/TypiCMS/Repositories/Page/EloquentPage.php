<?php namespace TypiCMS\Repositories\Page;

use Config;
use DB;

use TypiCMS\Models\PageTranslation;
use TypiCMS\Repositories\RepositoriesAbstract;
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

		$this->select = array('pages.id AS id', 'slug', 'title', 'status', 'position', 'parent');

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

		$data = array_except($data, Config::get('app.locales'), '_method', '_token');
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
			
			// Change position
			$model->position = $i;

			// Change parent
			( ! $parent) and $parent = 0;
			$model->parent = $parent;

			// save
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
			
			if ($model->$locale->slug) {

				$uri = ($parentModel) ? $parentModel->$locale->uri.'/'.$model->$locale->slug : $locale.'/'.$model->$locale->slug ;

				DB::table('pages_translations')->where('page_id', '=', $model->id)->where('lang', '=', $locale)->update(array('uri' => $uri));

			}

		}
	}

}