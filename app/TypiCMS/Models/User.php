<?php namespace TypiCMS\Models;

use Input;
use TypiCMS\NestedCollection;
use Cartalyst\Sentry\Users\Eloquent\User as SentryUserModel;

class User extends SentryUserModel {

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
	 * Returns the user full name, it simply concatenates
	 * the user first and last name.
	 *
	 * @return string
	 */
	public function fullName()
	{
		return $this->first_name . ' ' . $this->last_name;
	}


	/**
	 * lists
	 */
	public static $order = 'last_name';
	public static $direction = 'asc';

}