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

		$this->select = array(
			'id',
			'package',
			'group',
			'key',
			'value',
			'type',
			'environment',
		);

	}

    /**
     * Retrieve article by id
     * regardless of status
     *
     * @param  int $id item ID
     * @return stdObject object of article information
     */
    public function byId($id)
    {
    	return 'item';
    }

	/**
	 * Get all models
	 *
	 * @param boolean $all Show published or all
     * @return StdClass Object with $items
	 */
	public function getAll($all = false)
	{
    	return 'all';
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