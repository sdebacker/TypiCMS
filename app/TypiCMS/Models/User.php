<?php namespace TypiCMS\Models;

use Input;
use TypiCMS\NestedCollection;

class User extends Base {

	protected $fillable = array(
		'email',
		'permissions',
		'activated',
		'activated_at',
		'last_login',
		'first_name',
		'last_name',
	);

	
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

}