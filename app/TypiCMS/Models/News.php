<?php namespace TypiCMS\Models;

use Illuminate\Database\Eloquent\Collection;
use TypiCMS\NestedCollection;
use Input;
use Carbon\Carbon;

class News extends EloquentTranslatable {

	protected $guarded = array();
	
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
	public $itemsPerPage = 25;


	/**
	 * Relations
	 */
	public function files()
	{
		return $this->morphMany('TypiCMS\Models\File', 'fileable');
	}


	/**
	 * Translatable model configs.
	 *
	 * @var array
	 */
	public static $translatable = array(
		'translationModel' => 'TypiCMS\Models\NewsTranslation',
		'relationshipField' => 'news_id',
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