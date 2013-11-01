<?php namespace TypiCMS\Models;

use TypiCMS\NestedCollection;

class Setting extends \Eloquent {

	protected $guarded = array();
	
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'settings';

}