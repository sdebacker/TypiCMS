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

}