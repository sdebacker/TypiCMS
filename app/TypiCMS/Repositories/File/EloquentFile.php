<?php namespace TypiCMS\Repositories\File;

use Config;

use TypiCMS\Repositories\RepositoriesAbstract;
use TypiCMS\Services\Cache\CacheInterface;
use Illuminate\Database\Eloquent\Model;

class EloquentFile extends RepositoriesAbstract implements FileInterface {


	// Class expects an Eloquent model
	public function __construct(Model $model, CacheInterface $cache)
	{
		$this->model = $model;
		$this->cache = $cache;

		$this->listProperties = array(
			'display' => array('%s %s', 'filename', 'alt_attribute'),
		);

		$this->select = array('files.id AS id', 'filename', 'extension', 'alt_attribute', 'keywords', 'description', 'status', 'position');

	}


	/**
	 * Upoad files
	 *
	 * @param array  Data to create a new object
	 */
	public function upload(array $input)
	{
		$files = $input['file'];

		$destinationPath = 'uploads';
		
		foreach ($files as $file) {

			$dataArray = array();

			$dataArray['fileable_id'] = $input['fileable_id'];
			$dataArray['fileable_type'] = $input['fileable_type'];
			$dataArray['filename'] = $file->getClientOriginalName();
			$dataArray['extension'] = '.'.$file->getClientOriginalExtension();
			$dataArray['filesize'] = $file->getClientSize();
			$dataArray['mimetype'] = $file->getClientMimeType();
			$dataArray['path'] = $destinationPath;

			$filename = $file->getClientOriginalName();

			if( $file->move($destinationPath, $filename) ) {
				list($dataArray['width'], $dataArray['height']) = getimagesize($destinationPath.'/'.$filename);
				$this->model->create($dataArray);
			}

		}

	}

	public function delete($model)
	{
		if ($model->delete()) {
			unlink($model->path.'/'.$model->filename);
			return true;
		}
		return false;
	}

}