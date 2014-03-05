<?php namespace TypiCMS\Modules\Users\Models;

use Input;
use Cartalyst\Sentry\Users\Eloquent\User as SentryUserModel;

class User extends SentryUserModel {


	/**
	 * The default route for admin side.
	 *
	 * @var string
	 */
	public $route = 'users';


	/**
	 * lists
	 */
	public static $order = 'last_name';
	public static $direction = 'asc';

}