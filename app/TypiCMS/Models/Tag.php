<?php namespace TypiCMS\Models;

use Illuminate\Database\Eloquent\Collection;

class Tag extends Eloquent {

	protected $guarded = array();
	
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'tags';

	public $view = 'tags';
	public $route = 'tags';


	/**
	 * lists
	 */
	public $order = 'id';
	public $direction = 'desc';

}