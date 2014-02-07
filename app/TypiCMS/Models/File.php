<?php namespace TypiCMS\Models;

use TypiCMS\NestedCollection;

class File extends EloquentTranslatable {

	protected $fillable = array(
		'fileable_id',
		'fileable_type',
		'folder_id',
		'user_id',
		'type',
		'name',
		'filename',
		'path',
		'extension',
		'mimetype',
		'width',
		'height',
		'filesize',
		'download_count',
		'position',
	);
	
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
	public $order = 'position';
	public $direction = 'asc';


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