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
		$this->cache->flush('Files', 'Pages', 'Events', 'News', 'Projects', 'Dashboard');
		return $this->repo->upload($input);
	}



	/**
	 * Delete a file
	 *
	 * @param File model to delete
	 * @return bool
	 */
	public function delete($model)
	{
		var_dump($model);
		$this->cache->flush('Files', 'Pages', 'Events', 'News', 'Projects', 'Dashboard');
		return $this->repo->delete($model);
	}

}