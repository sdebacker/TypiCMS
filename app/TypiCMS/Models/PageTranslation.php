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
			// Construire l’uri de la page
			$model->uri = ($model->slug) ? $model->lang.'/'.$model->slug : null ;
		});

		static::updating(function($model)
		{
			$original = $model->getOriginal();

			$model->uri = ($model->uri) ? $model->uri : null ;

			// If slug has changed
			if ($model->slug != $original['slug']) {

				// Update page URI
				$array = explode('/', $model->uri);
				array_pop($array);
				$array[] = $model->slug;
				$newUri = implode('/', $array);

				$model->uri = ($newUri) ? $newUri : null ;

			}

		});

	}

}