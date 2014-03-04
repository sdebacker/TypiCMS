<?php namespace TypiCMS\Modules\Users\Models;

use Input;
use Cartalyst\Sentry\Users\Eloquent\User as SentryUserModel;

class User extends SentryUserModel {


	public $view = 'users';
	public $route = 'users';


	/**
	 * lists
	 */
	public static $order = 'last_name';
	public static $direction = 'asc';

}