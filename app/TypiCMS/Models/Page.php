<?php namespace TypiCMS\Models;

use Input;

use TypiCMS\NestedCollection;

class Page extends EloquentTranslatable {

	protected $guarded = array();
	
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'pages';

	public $view = 'pages';
	public $route = 'pages';

	/**
	 * lists
	 */
	public $order = 'position';
	public $direction = 'asc';

	
	/**
	 * For nested collection
	 *
	 * @var array
	 */
	public $children = array();

	
	/**
	 * Items per page
	 *
	 * @var string
	 */
	public $itemsPerPage = 5;


	
	/**
	 * Relations
	 */
	public function menulinks()
	{
		return $this->hasMany('TypiCMS\Models\Menulink');
	}

	public function files()
	{
		return $this->morphMany('File', 'fileable');
	}


	/**
	 * Scope from
	 */
	public function scopeFrom($query, $relid)
	{
		return $query;
	}


	/**
	 * Translatable model configs.
	 *
	 * @var array
	 */
	public static $translatable = array(
		'translationModel' => 'TypiCMS\Models\PageTranslation',
		'relationshipField' => 'page_id',
		'localeField' => 'lang',
		'translatables' => array(
			'title',
			'slug',
			'uri',
			'status',
			'body',
			'meta_title',
			'meta_keywords',
			'meta_description',
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

	/**
	 * Observers
	 */
	public static function boot()
	{
		parent::boot();

		static::saving(function($model)
		{
			// change homepage
			if (Input::get('is_home')) {
				self::where('is_home', 1)->update(array('is_home' => 0));
			}
		});

	}

}