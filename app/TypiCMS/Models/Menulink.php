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

}