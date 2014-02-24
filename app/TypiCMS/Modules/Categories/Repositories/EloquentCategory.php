<?php namespace TypiCMS\Modules\Categories\Repositories;

use TypiCMS\Repositories\RepositoriesAbstract;
use TypiCMS\Services\Cache\CacheInterface;
use Illuminate\Database\Eloquent\Model;

use App;

class EloquentCategory extends RepositoriesAbstract implements CategoryInterface {

	// Class expects an Eloquent model and a cache interface
	public function __construct(Model $model, CacheInterface $cache)
	{
		$this->model = $model;
		$this->cache = $cache;
	}

	public function getAllForSelect()
	{

		// Item not cached, retrieve it
		$query = $this->model->with('translations');

		// take only translated items that are online
		$query->whereHasOnlineTranslation();

		// Get
		$categories = $query->get();

		// Sorting of collection
		$desc = ($this->model->direction == 'desc') ? true : false ;
		$categories = $categories->sortBy(function($model)
		{
			return $model->{$this->model->order};
		}, null, $desc);

		$array = array('' => '');
		$categories->each(function($category) use(&$array)
		{
			$array[$category->id] = $category->title;
		});

		return $array;

	}

}