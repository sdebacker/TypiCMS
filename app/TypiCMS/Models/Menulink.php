<?php namespace TypiCMS\Models;

use Request;
use Config;
use TypiCMS\NestedCollection;

class Menulink extends EloquentTranslatable {

	protected $guarded = array();
	
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'menulinks';

	public $view = 'menulinks';
	public $route = 'menus.menulinks';


	/**
	 * lists
	 */
	public $order = 'position';
	public $direction = 'asc';


	/**
	 * For nested collection
	 *
	 * @var array
	 */
	public $children = array();


	/**
	 * Scope from
	 */
	public function scopeFrom($query, $relid)
	{
		return $query->where('menu_id', $relid);
	}


	/**
	 * Relation
	 */
	public function page()
	{
		return $this->belongsTo('TypiCMS\Models\Page');
	}


	/**
	 * Relation
	 */
	public function menu()
	{
		return $this->belongsTo('TypiCMS\Models\Menu');
	}


	/**
	 * Translatable model configs.
	 *
	 * @var array
	 */
	public static $translatable = array(
		'translationModel' => 'TypiCMS\Models\MenulinkTranslation',
		'relationshipField' => 'menulink_id',
		'localeField' => 'lang',
		'translatables' => array(
			'title',
			'uri',
			'url',
			'status',
		)
	);


	/**
	 * Custom collection
	 *
	 * @return InvoiceCollection object
	 */
	public function newCollection(array $models = array())
	{
		return new NestedCollection($models);
	}


	/**
	 * Build a menu from its name
	 *
	 * @return Menulinks Collection
	 */
	public static function getMenu($name)
	{

		$menulinks = static::select('menus.name', 'menulinks.id', 'menulinks.menu_id', 'menulinks.target', 'menulinks.parent', 'menulinks.page_id', 'menulinks.class', 'menulinks_translations.title', 'menulinks_translations.status', 'menulinks_translations.url', 'pages.is_home', 'pages_translations.uri as page_uri', 'pages_translations.lang', 'module_name')
			
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
			->get();

		return $menulinks;

	}

}