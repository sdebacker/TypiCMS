<?php namespace TypiCMS\Models;

use TypiCMS\NestedCollection;

class Group extends Base {

	protected $guarded = array();

	
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'groups';

	public $view = 'groups';
	public $route = 'groups';


	/**
	 * lists
	 */
	public static $order = 'name';
	public static $direction = 'asc';


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