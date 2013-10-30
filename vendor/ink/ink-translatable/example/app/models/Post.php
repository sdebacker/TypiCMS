<?php

use Ink\InkTranslatable\Models\EloquentTranslatable;

class Post extends EloquentTranslatable
{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'posts';
        	
	/**
	 * Translatable model configs.
	 *
	 * @var array
	 */
	public static $translatable = array(
		'translationModel'  => 'PostTranslation',
	    'relationshipField' => 'post_id',
	    'localeField'       => 'lang',
	    'translatables'     => array(
	        'title',
	    )
	);
}