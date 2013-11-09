<?php namespace TypiCMS\Models;

use Illuminate\Database\Eloquent\Collection;
use TypiCMS\NestedCollection;
use Input;

class Event extends EloquentTranslatable {

	protected $guarded = array();
	
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'events';

	public $view = 'events';
	public $route = 'events';


	/**
	 * lists
	 */
	public $order = 'start_date';
	public $direction = 'asc';


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
		'translationModel' => 'TypiCMS\Models\EventTranslation',
		'relationshipField' => 'event_id',
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
	public function getStartDateAttribute($value)
	{
		if ($value == '0000-00-00') return;
		return \DateTime::createFromFormat('Y-m-d', $value)->format('d.m.Y');
	}

	public function getEndDateAttribute($value)
	{
		if ($value == '0000-00-00') return;
		return \DateTime::createFromFormat('Y-m-d', $value)->format('d.m.Y');
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
			if (Input::get('start_date')) {
				$model->start_date = \DateTime::createFromFormat('d.m.Y', Input::get('start_date'))->format('Y-m-d');
			}
			if (Input::get('end_date')) {
				$model->end_date = \DateTime::createFromFormat('d.m.Y', Input::get('end_date'))->format('Y-m-d');
			}
		});

	}

}