<?php namespace TypiCMS\Models;

use Illuminate\Database\Eloquent\Collection;
use TypiCMS\NestedCollection;

class Menu extends EloquentTranslatable {

	protected $guarded = array();
	
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'menus';

	public $view = 'menus';
	public $route = 'menus';

	/**
	 * lists
	 */
	public $order = 'name';
	public $direction = 'asc';


	/**
	 * Relations
	 */
	public function menulinks()
	{
		return $this->hasMany('TypiCMS\Models\Menulink');
	}


	/**
	 * Validation rules
	 */
	public static $rules = array(
		'name' => 'required',
	);


	/**
	 * Translatable model configs.
	 *
	 * @var array
	 */
	public static $translatable = array(
		'translationModel' => 'TypiCMS\Models\MenuTranslation',
		'relationshipField' => 'menu_id',
		'localeField' => 'lang',
		'translatables' => array(
			'title',
			'status',
		)
	);


	/**
	 * Custom collection
	 *
	 * @return InvoiceCollection object
	 */
	public function newCollection(array $models = array())
	{
		return new NestedCollection($models);
	}

}