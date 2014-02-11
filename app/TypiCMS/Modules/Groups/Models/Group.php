<?php namespace TypiCMS\Modules\Groups\Models;

use Cartalyst\Sentry\Groups\Eloquent\Group as SentryGroupModel;

class Group extends SentryGroupModel {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'groups';

	public $view = 'groups';
	public $route = 'groups';

}