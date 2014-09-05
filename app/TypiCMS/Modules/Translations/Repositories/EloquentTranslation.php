<?php
namespace TypiCMS\Modules\Translations\Repositories;

use Config;
use Illuminate\Database\Eloquent\Model;
use TypiCMS\Repositories\RepositoriesAbstract;

class EloquentTranslation extends RepositoriesAbstract implements TranslationInterface
{

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Get all models
     *
     * @param  boolean  $all  Show published or all
     * @param  array    $with Eager load related models
     * @return StdClass Object with $items
     */
    public function getAll(array $with = array(), $all = false)
    {
        $query = $this->make(array('translations'));

        $data = array();

        $models = $query->order()->get();
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
    public function getAllToArray($locale, $group, $namespace = null)
    {
        $array = $this->model
                ->join('translation_translations', 'translations.id', '=', 'translation_translations.translation_id')
                ->where('locale', $locale)
                ->where('group', $group)
                ->lists('translation', 'key');

        return $array;
    }

    /**
     * Create a new model
     *
     * @param array  Data to create a new object
     * @return boolean
     */
    public function create(array $data)
    {
        if ($model = $this->model->create($data)) {
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
        isset($data['key']) && $data['key'] = htmlspecialchars($data['key']);
        foreach (Config::get('app.locales') as $locale) {
            if (isset($data[$locale]['translation'])) {
                $data[$locale]['translation'] = htmlspecialchars($data[$locale]['translation']);
            }
        }
        $model = $this->model->find($data['id']);
        $model->fill($data);
        $model->save();

        return true;
    }
}
