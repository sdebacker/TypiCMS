<?php namespace TypiCMS\Modules\Translations\Repositories;

use DB;
use App;
use Config;

use Illuminate\Database\Eloquent\Model;

use Setting;

use TypiCMS\Repositories\RepositoriesAbstract;

class EloquentTranslation extends RepositoriesAbstract implements TranslationInterface {


	// Class expects an Eloquent model
	public function __construct(Model $model)
	{
		$this->model = $model;
	}


	/**
	 * Get all models with categories
	 *
	 * @param boolean $all Show published or all
     * @return StdClass Object with $items
	 */
	public function getAll($all = false, $relid = null)
	{
		$query = $this->model->with('translations');
		
		$data = array();

		$models = $query->get();
		foreach ($models as $model) {
			$data[$model->id]['id'] = $model->id;
			$data[$model->id]['key'] = $model->key;
			foreach ($model->translations as $translation) {
				$data[$model->id][$translation->locale] = $translation->translation;
			}
		}
		return $data;
	}


	/**
	 * Get translations to Array
	 *
	 * @return array
	 */
	public function getAllToArray($locale = null)
	{
		if ($translations = Setting::get('translations.' . $locale)) {
			return $translations;
		}
		$this->saveToJSON();
		return $this->model
				->join('translation_translations', 'translations.id', '=', 'translation_translations.translation_id')
				->where('locale', $locale)
				->lists('translation', 'key');
	}


	/**
	 * Get all models ordered by locale
	 *
     * @return Array $data
	 */
	public function getAllByLocales()
	{
		$query = $this->model->with('translations');
		
		$data = array();

		$models = $query->get();
		foreach ($models as $model) {
			foreach ($model->translations as $translation) {
				$data[$translation->locale][$model->key] = $translation->translation;
			}
		}
		return $data;
	}


	/**
	 * Save to JSON
	 *
	 * @return void
	 */
	public function saveToJSON()
	{
		$translations = $this->getAllByLocales();
		foreach ($translations as $locale => $translation) {
			Setting::set('translations.' . $locale, $translation);
		}
	}


	/**
	 * Create a new model
	 *
	 * @param array  Data to create a new object
	 * @return boolean
	 */
	public function create(array $data)
	{
		if ( $model = $this->model->create($data) ) {
			$this->saveToJSON();
			return $model;
		}
		return false;
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
		$model->fill($data);
		$model->save();
		$this->saveToJSON();
		return true;
	}


	/**
	 * Delete model
	 *
	 * @return boolean
	 */
	public function delete($model)
	{
		if ($model->delete()) {
			$this->saveToJSON();
			return true;
		}
		return false;
	}


}