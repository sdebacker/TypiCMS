<?php namespace TypiCMS\Repositories\Menu;

use TypiCMS\Repositories\RepositoriesAbstract;
use TypiCMS\Services\Cache\CacheInterface;
use Illuminate\Database\Eloquent\Model;

class EloquentMenu extends RepositoriesAbstract implements MenuInterface {

	// Class expects an Eloquent model and a cache interface
	public function __construct(Model $model, CacheInterface $cache)
	{
		$this->model = $model;
		$this->cache = $cache;

		$this->listProperties = array(
			'display' => array('%s (%s)', 'title', 'name'),
		);

		$this->select = array(
			'menus.id AS id',
			'title',
			'status',
			'name'
		);

	}


}