<?php namespace TypiCMS\Modules\News\Repositories;

use TypiCMS\Repositories\RepositoriesAbstract;
use TypiCMS\Services\Cache\CacheInterface;

use Illuminate\Database\Eloquent\Model;

class EloquentNews extends RepositoriesAbstract implements NewsInterface {

	// Class expects an Eloquent model and a cache interface
	public function __construct(Model $model, CacheInterface $cache)
	{
		$this->model = $model;
		$this->cache = $cache;
	}


}