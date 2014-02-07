<?php namespace TypiCMS\Models;

use Illuminate\Database\Eloquent\Collection;
use TypiCMS\NestedCollection;

class Project extends EloquentTranslatable {

	protected $fillable = array(
		'category_id',
	);
	
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'projects';

	public $view = 'projects';
	public $route = 'projects';


	/**
	 * lists
	 */
	public $order = 'id';
	public $direction = 'desc';


	/**
	 * Items per page
	 *
	 * @var string
	 */
	public $itemsPerPage = 25;


	/**
	 * Relations
	 */
	public function files()
	{
		return $this->morphMany('TypiCMS\Models\File', 'fileable');
	}


	/**
	 * Relation
	 */
	public function category()
	{
		return $this->belongsTo('TypiCMS\Models\Category');
	}


	/**
	 * Translatable model configs.
	 *
	 * @var array
	 */
	public static $translatable = array(
		'translationModel' => 'TypiCMS\Models\ProjectTranslation',
		'relationshipField' => 'project_id',
		'localeField' => 'lang',
		'translatables' => array(
			'title',
			'slug',
			'status',
			'summary',
			'body',
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