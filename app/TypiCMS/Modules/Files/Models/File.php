<?php namespace TypiCMS\Modules\Files\Models;

use Dimsav\Translatable\Translatable;

class File extends Translatable {

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
		// Translatable fields
		'keywords',
		'description',
		'alt_attribute',
		'status',
	);
	

	/**
	 * Translatable model configs.
	 *
	 * @var array
	 */
	public $translatedAttributes = array(
		'keywords',
		'description',
		'alt_attribute',
		'status',
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
	 * Polymorphic relation.
	 */
	public function fileable()
	{
		return $this->morphTo();
	}


}