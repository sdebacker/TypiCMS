<?php namespace TypiCMS\Modules\Events\Repositories;

use TypiCMS\Repositories\RepositoriesAbstract;
use TypiCMS\Services\Cache\CacheInterface;
use Illuminate\Database\Eloquent\Model;

class EloquentEvent extends RepositoriesAbstract implements EventInterface {

	// Class expects an Eloquent model and a cache interface
	public function __construct(Model $model, CacheInterface $cache)
	{
		$this->model = $model;
		$this->cache = $cache;

		$this->listProperties = array(
			'display' => array('%s > %s : %s', 'start_date', 'end_date', 'title'),
		);

		$this->select = array(
			'events.id AS id',
			'start_date',
			'end_date',
			'start_time',
			'end_time',
			'slug',
			'title',
			'status',
		);

	}


}