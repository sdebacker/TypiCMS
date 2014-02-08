<?php namespace TypiCMS\Models;

use Dimsav\Translatable\Translatable;

use Request;
use Config;
use TypiCMS\NestedCollection;

class Menulink extends Translatable {

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
	public $translatedAttributes = array(
		'title',
		'uri',
		'url',
		'status',
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

}