<?php namespace TypiCMS\Modules\Projects\Models;

use Illuminate\Database\Eloquent\Collection;

use Dimsav\Translatable\Translatable;

use TypiCMS\NestedCollection;

class Project extends Translatable {

	protected $fillable = array(
		'category_id',
		// Translatable fields
		'title',
		'slug',
		'status',
		'summary',
		'body',
	);
	

	/**
	 * Translatable model configs.
	 *
	 * @var array
	 */
	public $translatedAttributes = array(
		'title',
		'slug',
		'status',
		'summary',
		'body',
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
		return $this->morphMany('TypiCMS\Modules\Files\Models\File', 'fileable');
	}


	/**
	 * Relation
	 */
	public function category()
	{
		return $this->belongsTo('TypiCMS\Modules\Categories\Models\Category');
	}


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