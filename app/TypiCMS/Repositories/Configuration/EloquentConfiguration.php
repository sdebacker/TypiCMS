<?php namespace TypiCMS\Repositories\Configuration;

use Config;
use DBconfig;

use TypiCMS\Repositories\RepositoriesAbstract;
use TypiCMS\Services\Cache\CacheInterface;

class EloquentConfiguration implements ConfigurationInterface {

	// Class expects an Eloquent model and a cache interface
	public function __construct(CacheInterface $cache)
	{
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
		// save translated settings
		foreach (Config::get('app.locales') as $lang) {
			foreach ($data[$lang] as $key => $value) {
				// d($lang.'.'.$key, $value);
				DBconfig::set($lang.'.'.$key, $value);
			}
		}
		// save other settings
		$data = array_except($data, Config::get('app.locales'));
		foreach ($data as $key => $value) {
			// d($key, $value);
			DBconfig::set($key, $value);
		}
		exit();
		return true;
	}


	/**
	 * Update an existing model
	 *
	 * @param array  Data to update a model
	 * @return boolean
	 */
	public function update(array $data)
	{

		$model = $this->model->find($data['id']);

		$data = array_except($data, Config::get('app.locales'), '_method', '_token');
		$data = array_except($data, '_method');
		$data = array_except($data, '_token');

		foreach ($data as $key => $value) {
			$model->$key = $value;
		}

		$model->save();

		return true;
		
	}

}