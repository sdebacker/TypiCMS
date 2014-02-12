<?php namespace TypiCMS\Modules\Menulinks\Models;

use TypiCMS\Models\Base;
use TypiCMS\NestedCollection;

use Request;
use Config;

class Menulink extends Base {

	use \Dimsav\Translatable\Translatable;

	protected $fillable = array(
		'menu_id',
		'page_id',
		'parent',
		'position',
		'target',
		'module_name',
		'restricted_to',
		'class',
		'link_type',
		// Translatable fields
		'title',
		'uri',
		'url',
		'status',
	);
	

	/**
	 * Translatable model configs.
	 *
	 * @var array
	 */
	public $translatedAttributes = array(
		'title',
		'uri',
		'url',
		'status',
	);


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
		return $this->belongsTo('TypiCMS\Modules\Pages\Models\Page');
	}


	/**
	 * Relation
	 */
	public function menu()
	{
		return $this->belongsTo('TypiCMS\Modules\Menus\Models\Menu');
	}


	/**
	 * Custom collection
	 *
	 * @return InvoiceCollection object
	 */
	public function newCollection(array $models = array())
	{
		return new NestedCollection($models);
	}

}