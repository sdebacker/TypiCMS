<?php namespace TypiCMS\Modules\Places\Models;

use Illuminate\Database\Eloquent\Collection;
use TypiCMS\NestedCollection;
use Input;
use Carbon\Carbon;

class Place extends \TypiCMS\Models\EloquentTranslatable {

	protected $guarded = array();
	
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'places';

	public $view = 'places';
	public $route = 'places';


	/**
	 * lists
	 */
	public $order = 'position';
	public $direction = 'asc';


	/**
	 * Items per page
	 *
	 * @var string
	 */
	public $itemsPerPage = 10;


	/**
	 * Translatable model configs.
	 *
	 * @var array
	 */
	public static $translatable = array(
		'translationModel' => 'TypiCMS\Modules\Places\Models\PlaceTranslation',
		'relationshipField' => 'place_id',
		'localeField' => 'lang',
		'translatables' => array(
			'info',
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

		$self = __CLASS__;
		
		static::creating(function($model) use ($self)
		{
			// slug = null si vide
			$slug = ($model->slug) ? $model->slug : null ;
			$model->slug = $slug;

			if ($slug) {
				$i = 0;
				// Check uri is unique
				while ($self::where('slug', $model->slug)->first()) {
					$i++;
					// increment uri if exists
					$model->slug = $slug.'-'.$i;
				}
			}

		});

		static::updating(function($model) use ($self)
		{
			// slug = null si vide
			$slug = ($model->slug) ? $model->slug : null ;
			$model->slug = $slug;

			if ($slug) {
				$i = 0;
				// Check uri is unique
				while ($self::where('slug', $model->slug)->where('id', '!=', $model->id)->first()) {
					$i++;
					// increment uri if exists
					$model->slug = $slug.'-'.$i;
				}
			}

		});

	}

}