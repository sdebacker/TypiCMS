<?php namespace TypiCMS\Modules\Files\Repositories;

use Response;
use Str;
use Croppa;

use TypiCMS\Repositories\RepositoriesAbstract;
use TypiCMS\Services\Cache\CacheInterface;
use Illuminate\Database\Eloquent\Model;

class EloquentFile extends RepositoriesAbstract implements FileInterface {


	// Class expects an Eloquent model
	public function __construct(Model $model, CacheInterface $cache)
	{
		$this->model = $model;
		$this->cache = $cache;

		$this->select = array(
			'files.id AS id',
			'path',
			'filename',
			'width',
			'height',
			'extension',
			'alt_attribute',
			'keywords',
			'description',
			'status',
			'position',
		);

	}


	/**
	 * Upoad files
	 *
	 * @param array  Data to create a new object
	 */
	public function upload(array $input)
	{
		$file = $input['file'];

		$fileName = Str::slug(pathinfo($file->getClientOriginalName(),PATHINFO_FILENAME));

		$dataArray = array();
		$dataArray['path']          = 'uploads';
		$dataArray['fileable_id']   = $input['fileable_id'];
		$dataArray['fileable_type'] = $input['fileable_type'];
		$dataArray['extension']     = '.'.$file->getClientOriginalExtension();
		$dataArray['filesize']      = $file->getClientSize();
		$dataArray['mimetype']      = $file->getClientMimeType();
		$dataArray['filename']      = $fileName.$dataArray['extension'];

		$filecounter = 1;
		while (file_exists($dataArray['path'].'/'.$dataArray['filename'])) {
			$dataArray['filename'] = $fileName.'_'.$filecounter++.$dataArray['extension'];
		}

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
			Croppa::delete($model->path.'/'.$model->filename);
			// unlink($model->path.'/'.$model->filename);
			return true;
		}
		return false;
	}

}