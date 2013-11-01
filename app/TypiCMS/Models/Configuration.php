<?php namespace TypiCMS\Models;

use TypiCMS\NestedCollection;

class Configuration extends \Eloquent {

	protected $guarded = array();
	
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'configuration';

	public $view = 'configuration';
	public $route = 'configuration';


	/**
	 * lists
	 */
	public $order = 'id';
	public $direction = 'desc';

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