<?php namespace TypiCMS\Models;

use Illuminate\Database\Eloquent\Collection;
use TypiCMS\NestedCollection;

class Category extends EloquentTranslatable {

	protected $guarded = array();
	
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'categories';

	public $view = 'categories';
	public $route = 'categories';


	/**
	 * lists
	 */
	public $order = 'position';
	public $direction = 'asc';


	/**
	 * Relations
	 */
	public function projects()
	{
		return $this->hasMany('TypiCMS\Models\Project');
	}


	/**
	 * Translatable model configs.
	 *
	 * @var array
	 */
	public static $translatable = array(
		'translationModel' => 'TypiCMS\Models\CategoryTranslation',
		'relationshipField' => 'category_id',
		'localeField' => 'lang',
		'translatables' => array(
			'title',
			'slug',
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