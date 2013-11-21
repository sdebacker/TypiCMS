<?php namespace TypiCMS\Repositories\Menulink;

use Config;
use App;
use Request;

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

		$models = $this->model->select('menus.name', 'menulinks.id', 'menulinks.menu_id', 'menulinks.target', 'menulinks.parent', 'menulinks.page_id', 'menulinks.class', 'menulinks_translations.title', 'menulinks_translations.status', 'menulinks_translations.url', 'pages.is_home', 'pages_translations.uri as page_uri', 'pages_translations.lang', 'module_name')
			
			->with('translations')
			->join('menus', 'menulinks.menu_id', '=', 'menus.id')
			->join('menulinks_translations', 'menulinks.id', '=', 'menulinks_translations.menulink_id')
			->leftJoin('pages', 'pages.id', '=', 'menulinks.page_id')
			->leftJoin('pages_translations', 'pages_translations.page_id', '=', 'menulinks.page_id')

			->where('menulinks_translations.lang', Config::get('app.locale'))
			->where(function($query){
				$query->where('pages_translations.lang', Config::get('app.locale'));
				$query->orWhere('pages_translations.lang', null);
			})
			->where('menus.name', $name)
			->where('menulinks_translations.status', 1)

			->orderBy('menulinks.position')
			->remember(10000)
			->get();

		// Store in cache for next request
		$this->cache->put($key, $models);

		return $models;

	}


	public function getPagesForSelect()
	{
		$pagesArray = Page::select('pages.id', 'title', 'lang')->joinTranslations()->where('lang', Config::get('app.locale'))->lists('id', 'title');
		$pagesArray = array_merge(array('' => '0'), $pagesArray);
		$pagesArray = array_flip($pagesArray);
		return $pagesArray;
	}

}