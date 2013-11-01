<?php namespace TypiCMS\Repositories\Configuration;

use Config;

use TypiCMS\Repositories\RepositoriesAbstract;
use TypiCMS\Services\Cache\CacheInterface;
use Illuminate\Database\Eloquent\Model;

class EloquentConfiguration implements ConfigurationInterface {

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
		$key = md5('configurationsall');

		if ( $this->cache->active('admin') and $this->cache->has($key) ) {
			return $this->cache->get($key);
		}

		// Item not cached, retrieve it
		$datas = array();
		foreach ($this->model->get() as $model) {
			$value = is_numeric($model->value) ? (int) $model->value : $model->value ;
			$datas[$model->group][$model->key] = $value;
		}
		$datas = (object) $datas;

		// Store in cache for next request
		$this->cache->put($key, $datas);

		return $datas;
	}


	/**
	 * Create a new model
	 *
	 * @param array  Data to create a new object
	 * @return boolean
	 */
	public function create(array $data)
	{
		return $this->update($data);
	}


	/**
	 * Update an existing model
	 *
	 * @param array  Data to update a model
	 * @return boolean
	 */
	public function update(array $data)
	{

		$data = array_except($data, '_method');
		$data = array_except($data, '_token');

		foreach ($data as $key => $value) {
			if (is_array($value)) {
				foreach ($value as $key2 => $value2) {
					// d($key, $key2, $value2);
					$model = $this->model->where('key', $key2)->where('group', $key)->first();
					$model = $model ? $model : new $this->model ;
					$model->group = $key;
					$model->key = $key2;
					$model->value = $value2;
					$save = $model->save();
					// d($save);
				}
			} else {
				$model = $this->model->where('key', $key)->where('group', 'config')->first();
				$model = $model ? $model : new $this->model ;
				$model->key = $key;
				$model->value = $value;
				$model->save();
			}
		}

		return true;
		
	}

}