<?php namespace TypiCMS\Modules\Translations\Repositories;

use App;
use Config;

use Illuminate\Database\Eloquent\Model;

use TypiCMS\Repositories\RepositoriesAbstract;
use TypiCMS\Modules\Tags\Repositories\TagInterface;

class EloquentTranslation extends RepositoriesAbstract implements TranslationInterface {

    protected $tag;

	// Class expects an Eloquent model and a TagInterface
	public function __construct(Model $model, TagInterface $tag)
	{
		$this->model = $model;
		$this->tag = $tag;
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
	 * Create a new model
	 *
	 * @param array  Data to create a new object
	 * @return boolean
	 */
	public function create(array $data)
	{
		if ( $model = $this->model->create($data) ) {
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
		return true;
	}


}