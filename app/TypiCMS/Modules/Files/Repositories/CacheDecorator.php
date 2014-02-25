<?php namespace TypiCMS\Modules\Files\Repositories;

use Str;
use Input;
use Croppa;
use Response;

use TypiCMS\Repositories\CacheAbstractDecorator;
use TypiCMS\Services\Cache\CacheInterface;
use Illuminate\Database\Eloquent\Model;

class CacheDecorator extends CacheAbstractDecorator implements FileInterface {


	// Class expects a repo and a cache interface
	public function __construct(FileInterface $repo, CacheInterface $cache)
	{
		$this->repo = $repo;
		$this->cache = $cache;
	}


	/**
	 * Upoad files
	 *
	 * @param array  Data to create a new object
	 */
	public function upload(array $input)
	{
		return $this->repo->upload($input);
	}


	/**
	 * Delete a file
	 *
	 * @param File model to delete
	 */
	public function delete($model)
	{
		return $this->repo->delete($model);
	}

}