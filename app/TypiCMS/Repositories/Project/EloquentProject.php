<?php namespace TypiCMS\Repositories\Project;

use Config;
use App;
use Request;

use TypiCMS\Repositories\RepositoriesAbstract;
use TypiCMS\Services\Cache\CacheInterface;
use Illuminate\Database\Eloquent\Model;

class EloquentProject extends RepositoriesAbstract implements ProjectInterface {

	// Class expects an Eloquent model and a cache interface
	public function __construct(Model $model, CacheInterface $cache)
	{
		$this->model = $model;
		$this->cache = $cache;

		$this->listProperties = array(
			'display' => array('%s', 'title'),
		);

		$this->select = array(
			'projects.id AS id',
			'slug',
			'title',
			'category_id',
			'status',
		);

	}


	/**
	 * Get all models
	 *
	 * @param boolean $all Show published or all
     * @return StdClass Object with $items
	 */
	public function getAll($all = false, $relid = null)
	{
		// Build our cache item key, unique per model number,
		// limit and if we're showing all
		$allkey = ($all) ? '.all' : '';
		$key = md5(App::getLocale().'all'.$allkey);

		if ( Request::segment(1) != 'admin' and $this->cache->active('public') and $this->cache->has($key) ) {
			return $this->cache->get($key);
		}

		// Item not cached, retrieve it
		$query = $this->model
			->with('translations')
			->with('category')
			->with('category.translations');
			// ->select($this->select);
		$relid and $query->where('category_id', $relid);
		// $query->joinTranslations();
		// $query->where('lang', Config::get('app.locale'));

		// All posts or only published
		if ( ! $all ) {
			$query->where('status', 1);
		}


		if ($this->model->order and $this->model->direction) {
			$query->orderBy($this->model->order, $this->model->direction);
		}

		$models = $query->get();

		// Store in cache for next request
		$this->cache->put($key, $models);

		return $models;
	}


}