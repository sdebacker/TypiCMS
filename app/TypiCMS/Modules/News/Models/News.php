<?php namespace TypiCMS\Modules\News\Models;

use TypiCMS\Models\Base;

use Input;
use Carbon\Carbon;

class News extends Base {

	use \Dimsav\Translatable\Translatable;

	protected $fillable = array(
		'date',
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
	protected $table = 'news';

	public $view = 'news';
	public $route = 'news';


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
	public $itemsPerPage = 10;


	/**
	 * Relations
	 */
	public function files()
	{
		return $this->morphMany('TypiCMS\Modules\Files\Models\File', 'fileable');
	}


	/**
	 * Accessors
	 *
	 * @return string
	 */
	public function getDateAttribute($value)
	{
		if ($value == '0000-00-00 00:00') return;
		return Carbon::parse($value)->format('d.m.Y H:i');
	}


	/**
	 * Observers
	 */
	public static function boot()
	{
		parent::boot();

		static::saving(function($model)
		{
			// transform dates to sql
			if (Input::get('date')) {
				$model->date = Carbon::createFromFormat('d.m.Y H:i', Input::get('date'))->toDateTimeString();
			}
		});

	}

}