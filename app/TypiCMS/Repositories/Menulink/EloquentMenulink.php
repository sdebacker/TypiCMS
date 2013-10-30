<?php namespace TypiCMS\Repositories\Menulink;

use Config;

use TypiCMS\Repositories\RepositoriesAbstract;
use TypiCMS\Services\Cache\CacheInterface;
use TypiCMS\Models\Page;
use Illuminate\Database\Eloquent\Model;

class EloquentMenulink extends RepositoriesAbstract implements MenulinkInterface {

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

	}

	/**
	 * Get all models
	 *
	 * @param boolean $all Show published or all
     * @return StdClass Object with $items
	 */
	public function getAllFromMenu($all = false, $relid = null)
	{
		// Build our cache item key, unique per model number,
		// limit and if we're showing all
		$allkey = ($all) ? '.all' : '';
		$key = md5($this->view().'all'.$allkey);

		if ( $this->cache->active('admin') and $this->cache->has($key) ) {
			return $this->cache->get($key);
		}

		// Item not cached, retrieve it
		$query = $this->model->with('translations')
			->orderBy('position', 'asc')
			->where('menu_id', $relid);

		// All posts or only published
		if ( ! $all ) {
			$query->where('status', 1);
		}

		$models = $query->get()->nest();

		// Store in cache for next request
		$this->cache->put($key, $models);

		return $models;
	}

	public function getPagesForSelect()
	{
		$pagesArray = Page::select('pages.id', 'title', 'lang')->joinTranslations()->where('lang', Config::get('app.contentlocale'))->lists('id', 'title');
		$pagesArray = array_merge(array('' => '0'), $pagesArray);
		$pagesArray = array_flip($pagesArray);
		return $pagesArray;
	}

}