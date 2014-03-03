<?php namespace TypiCMS\Modules\Users\Models;

use Input;
use Cartalyst\Sentry\Users\Eloquent\User as SentryUserModel;

class User extends SentryUserModel {


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