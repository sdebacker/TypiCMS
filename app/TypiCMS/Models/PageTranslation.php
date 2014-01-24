<?php namespace TypiCMS\Models;

use Eloquent;

class PageTranslation extends Eloquent {
	
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'pages_translations';


	/**
	 * Observers
	 */
	public static function boot()
	{
		parent::boot();

		static::creating(function($model)
		{
			// Build page's URI
			$model->uri = null;
			if ($model->slug) {
				$slug = $model->slug;
				$model->uri = $model->lang.'/'.$slug;

				$i = 0;
				// Check uri is unique
				while (self::where('uri', $model->uri)->first()) {
					$i++;
					// increment uri if exists
					$model->uri = $model->lang.'/'.$model->slug.'-'.$i;
					// $model->slug = $slug.'-'.$i;
				}

			}
		});

		static::updating(function($model)
		{
			$original = $model->getOriginal();

			$model->uri = ($model->uri) ? $model->uri : null ;

			// If slug has changed
			if ($model->slug != $original['slug']) {

				// Update page URI
				$slug = $model->slug;
				$array = explode('/', $model->uri);
				array_pop($array);
				$array[] = $model->slug;
				$uri = implode('/', $array);

				$model->uri = $uri;

				$i = 0;
				// Check uri is unique
				while (self::where('uri', $model->uri)->first()) {
					$i++;
					// increment uri if exists
					$model->uri = $uri.'-'.$i;
				}

			}

		});

	}

}