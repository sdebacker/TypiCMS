<?php namespace TypiCMS\Models;

use Eloquent;

class CategoryTranslation extends Eloquent {
	
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'categories_translations';

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
				while ($self::where('slug', $model->slug)->where('lang', $model->lang)->first()) {
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
				while ($self::where('slug', $model->slug)->where('id', '!=', $model->id)->where('lang', $model->lang)->first()) {
					$i++;
					// increment uri if exists
					$model->slug = $slug.'-'.$i;
				}
			}

		});

	}

}