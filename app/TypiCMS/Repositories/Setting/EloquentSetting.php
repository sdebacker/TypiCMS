<?php namespace TypiCMS\Repositories\Setting;

use Config;

use TypiCMS\Repositories\RepositoriesAbstract;
use TypiCMS\Services\Cache\CacheInterface;
use Illuminate\Database\Eloquent\Model;

class EloquentSetting implements SettingInterface {

	// Class expects an Eloquent model and a cache interface
	public function __construct(Model $model, CacheInterface $cache)
	{
		$this->model = $model;
		$this->cache = $cache;

		$this->listProperties = array(
			'sortable' => true,
			'display' => array('%s %s', 'key', 'value')
		);

	}


	/**
	 * Get all models
	 *
     * @return StdClass Object with $items
	 */
	public function getAll()
	{
		// Build our cache item key, unique per model number,
		// limit and if we're showing all
		$key = md5('Settingsall');

		if ( $this->cache->active('admin') and $this->cache->has($key) ) {
			return $this->cache->get($key);
		}

		// Item not cached, retrieve it
		$data = array();
		foreach ($this->model->get() as $model) {
			$value = is_numeric($model->value) ? (int) $model->value : $model->value ;
			if ($model->group != 'config') {
				$data[$model->group][$model->key] = $value;
			} else {
				$data[$model->key] = $value;
			}
		}
		$data = (object) $data;

		// Store in cache for next request
		$this->cache->put($key, $data);

		return $data;
	}


	/**
	 * Update an existing model
	 *
	 * @param array  Data to update a model
	 * @return boolean
	 */
	public function store(array $data)
	{

		$data = array_except($data, '_method');
		$data = array_except($data, '_token');

		foreach ($data as $group => $array) {
			if ( ! is_array($array)) {
				$array = array($group => $array);
				$group = 'config';
			}
			foreach ($array as $key => $value) {
				$model = $this->model->where('key', $key)->where('group', $group)->first();
				$model = $model ? $model : new $this->model ;
				$model->group = $group;
				$model->key = $key;
				$model->value = $value;
				$save = $model->save();
			}
		}

		return true;
		
	}

}