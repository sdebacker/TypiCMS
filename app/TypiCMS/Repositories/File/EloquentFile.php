<?php namespace TypiCMS\Repositories\File;

use Config;
use Response;

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

		$this->select = array('files.id AS id', 'path', 'filename', 'width', 'height', 'extension', 'alt_attribute', 'keywords', 'description', 'status', 'position');

	}


	/**
	 * Upoad files
	 *
	 * @param array  Data to create a new object
	 */
	public function upload(array $input)
	{
		$file = $input['file'];
		
		$dataArray = array();
		$dataArray['path']          = 'uploads';
		$dataArray['fileable_id']   = $input['fileable_id'];
		$dataArray['fileable_type'] = $input['fileable_type'];
		$dataArray['filename']      = $file->getClientOriginalName();
		$dataArray['extension']     = '.'.$file->getClientOriginalExtension();
		$dataArray['filesize']      = $file->getClientSize();
		$dataArray['mimetype']      = $file->getClientMimeType();

		$upload_success = $file->move($dataArray['path'], $dataArray['filename']);

		if ( $upload_success ) {
			list($dataArray['width'], $dataArray['height']) = getimagesize($dataArray['path'].'/'.$dataArray['filename']);
			$this->model->create($dataArray);
			return Response::json('success', 200);
		} else {
			return Response::json('error', 400);
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