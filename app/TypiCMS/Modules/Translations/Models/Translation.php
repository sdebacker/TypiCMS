<?php namespace TypiCMS\Modules\Translations\Models;

use TypiCMS\Models\Base;

class Translation extends Base {

	use \Dimsav\Translatable\Translatable;

	protected $fillable = array(
		'group',
		'key',
		// Translatable fields
		'translation'
	);


	/**
	 * Translatable model configs.
	 *
	 * @var array
	 */
	public $translatedAttributes = array(
		'translation'
	);


	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	public $route = 'translations';
	public $view = 'translations';


	/**
	 * Lists
	 */
	public $order = 'key';
	public $direction = 'asc';

}