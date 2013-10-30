<?php namespace TypiCMS\Models;

use Input;
use TypiCMS\NestedCollection;

class User extends Base {

	protected $guarded = array();

	
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	public $view = 'users';
	public $route = 'users';


	/**
	 * lists
	 */
	public static $order = 'id';
	public static $direction = 'asc';


	// public function scopeOrder($query)
	// {
	// 	$order = Input::get('firstname', 'id');
	// 	$direction = Input::get('dir', 'desc');
	// 	return $query->orderBy($order, $direction)->orderBy('id', $direction);
	// }

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