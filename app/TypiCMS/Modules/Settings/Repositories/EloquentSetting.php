<?php namespace TypiCMS\Modules\Settings\Repositories;

use DB;
use stdClass;

use TypiCMS\Repositories\RepositoriesAbstract;
use Illuminate\Database\Eloquent\Model;

class EloquentSetting implements SettingInterface {

	// Class expects an Eloquent model
	public function __construct(Model $model)
	{
		$this->model = $model;
	}


	/**
	 * Get all models
	 *
     * @return StdClass Object with $items
	 */
	public function getAll($all = false, $relatedModel = null)
	{
		$data = new stdClass;
		foreach ($this->model->get() as $model) {
			$value = is_numeric($model->value) ? (int) $model->value : $model->value ;
			$group_name = $model->group_name;
			$key_name = $model->key_name;
			if ($group_name != 'config') {
				if ( ! isset($data->$group_name) ) {
					$data->$group_name = new stdClass;
				}
				$data->$group_name->$key_name = $value;
			} else {
				$data->$key_name = $value;
			}
		}

		return $data;
	}


	/**
	 * Update an existing model
	 *
	 * @param array Data to update a model
	 * @return boolean
	 */
	public function store(array $data)
	{

		$data = array_except($data, array('_method', '_token', 'exit'));

		foreach ($data as $group_name => $array) {
			if ( ! is_array($array)) {
				$array = array($group_name => $array);
				$group_name = 'config';
			}
			foreach ($array as $key_name => $value) {
				$model = $this->model->where('key_name', $key_name)->where('group_name', $group_name)->first();
				$model = $model ? $model : new $this->model ;
				$model->group_name = $group_name;
				$model->key_name = $key_name;
				$model->value = $value;
				$save = $model->save();
			}
		}

		return true;
		
	}


	/**
	 * Build Settings Array
	 *
	 * @return array
	 */
	public function getAllToArray()
	{
		$config = array();
		foreach (DB::table('settings')->get() as $object) {
			$key = $object->key_name;
			if ($object->group_name != 'config') {
				$config[$object->group_name][$key] = $object->value;
			} else {
				$config[$key] = $object->value;
			}
		}
		return $config;
	}

}