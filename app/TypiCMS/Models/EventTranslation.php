<?php namespace TypiCMS\Models;

use Eloquent;

class EventTranslation extends Eloquent {
	
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'events_translations';

	/**
	 * Observers
	 */
	public static function boot()
	{
		parent::boot();

		static::saving(function($model)
		{
			// slug = null si vide
			$model->slug = ($model->slug) ? $model->slug : null ;
		});

	}

}