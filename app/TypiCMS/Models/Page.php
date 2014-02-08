<?php namespace TypiCMS\Models;

use Dimsav\Translatable\Translatable;

use Input;

use TypiCMS\NestedCollection;

class Page extends Translatable {

	protected $fillable = array(
		'meta_robots_no_index',
		'meta_robots_no_follow',
		'position',
		'parent',
		'rss_enabled',
		'comments_enabled',
		'is_home',
		'css',
		'js',
		'template',
	);

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
		return $this->morphMany('TypiCMS\Models\File', 'fileable');
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
	public $translatedAttributes = array(
		'title',
		'slug',
		'uri',
		'status',
		'body',
		'meta_title',
		'meta_keywords',
		'meta_description',
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

		$self = __CLASS__;

		static::saving(function($model) use ($self)
		{
			// change homepage
			if (Input::get('is_home')) {
				$self::where('is_home', 1)->update(array('is_home' => 0));
			}
		});

	}

}