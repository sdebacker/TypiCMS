<?php namespace TypiCMS\Modules\Menulinks\Repositories;

use App;
use Config;

use Illuminate\Database\Eloquent\Model;

use TypiCMS\Repositories\RepositoriesAbstract;
use TypiCMS\Modules\Pages\Models\Page;

class EloquentMenulink extends RepositoriesAbstract implements MenulinkInterface {

	// Class expects an Eloquent model
	public function __construct(Model $model)
	{
		$this->model = $model;
	}

	/**
	 * Get all models
	 *
	 * @param boolean $all Show published or all
     * @return StdClass Object with $items
	 */
	public function getAllFromMenu($all = false, $relid = null)
	{
		$query = $this->model->with('translations')
			->orderBy('position', 'asc')
			->where('menu_id', $relid);

		// All posts or only published
		if ( ! $all ) {
			$query->where('status', 1);
		}

		$models = $query->get()->nest();

		return $models;
	}


	/**
	 * Build a menu from its name
	 *
	 * @return Menulinks Collection
	 */
	public function getMenu($name)
	{

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
			->get();

		$models->class = $models->first()->menuclass;

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