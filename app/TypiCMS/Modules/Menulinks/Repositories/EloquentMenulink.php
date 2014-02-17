<?php namespace TypiCMS\Modules\Menulinks\Repositories;

use Config;
use App;
use Request;

use TypiCMS\Repositories\RepositoriesAbstract;
use TypiCMS\Services\Cache\CacheInterface;
use TypiCMS\Modules\Pages\Models\Page;
use Illuminate\Database\Eloquent\Model;

class EloquentMenulink extends RepositoriesAbstract implements MenulinkInterface {

	// Class expects an Eloquent model and a cache interface
	public function __construct(Model $model, CacheInterface $cache)
	{
		$this->model = $model;
		$this->cache = $cache;
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
		$key = md5(App::getLocale().'all'.$allkey);

		if ( Request::segment(1) != 'admin' and $this->cache->active('public') and $this->cache->has($key) ) {
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


	/**
	 * Build a menu from its name
	 *
	 * @return Menulinks Collection
	 */
	public function getMenu($name)
	{

		// Build our cache item key, unique per model number,
		$key = md5(App::getLocale().'getMenu'.$name);

		if ( Request::segment(1) != 'admin' and $this->cache->active('public') and $this->cache->has($key) ) {
			return $this->cache->get($key);
		}

		$models = $this->model->select('menus.name', 'menus.class AS menuclass', 'menulinks.id', 'menulinks.menu_id', 'menulinks.target', 'menulinks.parent', 'menulinks.page_id', 'menulinks.class', 'menulink_translations.title', 'menulink_translations.status', 'menulink_translations.url', 'pages.is_home', 'page_translations.uri as page_uri', 'page_translations.locale', 'module_name')
			
			->with('translations')
			->join('menus', 'menulinks.menu_id', '=', 'menus.id')
			->join('menulink_translations', 'menulinks.id', '=', 'menulink_translations.menulink_id')
			->leftJoin('pages', 'pages.id', '=', 'menulinks.page_id')
			->leftJoin('page_translations', 'page_translations.page_id', '=', 'menulinks.page_id')

			->where('menulink_translations.locale', Config::get('app.locale'))
			->where(function($query){
				$query->where('page_translations.locale', Config::get('app.locale'));
				$query->orWhere('page_translations.locale', null);
			})
			->where('menus.name', $name)
			->where('menulink_translations.status', 1)

			->orderBy('menulinks.position')
			->remember(10000)
			->get();

		$models->class = $models->first()->menuclass;
		// Store in cache for next request
		$this->cache->put($key, $models);

		return $models;

	}


	public function getPagesForSelect()
	{
		$pagesArray = Page::select('pages.id', 'title', 'locale')
			->join('page_translations', 'pages.id', '=', 'page_translations.page_id')
			->where('locale', Config::get('app.locale'))
			->lists('id', 'title');
		$pagesArray = array_merge(array('' => '0'), $pagesArray);
		$pagesArray = array_flip($pagesArray);
		return $pagesArray;
	}

}