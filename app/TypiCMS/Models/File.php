<?php namespace TypiCMS\Models;

use TypiCMS\NestedCollection;

class File extends EloquentTranslatable {

	protected $guarded = array();
	
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'files';

	public $view = 'files';
	public $route = 'files';


	/**
	 * lists
	 */
	public $order = 'id';
	public $direction = 'desc';


	/**
	 * Translatable model configs.
	 *
	 * @var array
	 */
	public static $translatable = array(
		'translationModel' => 'TypiCMS\Models\FileTranslation',
		'relationshipField' => 'file_id',
		'localeField' => 'lang',
		'translatables' => array(
			'keywords',
			'description',
			'alt_attribute',
			'status',
		)
	);

 	/**
	 * Polymorphic relation.
	 */
	public function fileable()
	{
		return $this->morphTo();
	}

	/**
	 * Custom collection
	 *
	 * @return InvoiceCollection object
	 */
	public function newCollection(array $models = array())
	{
		return new NestedCollection($models);
	}

}