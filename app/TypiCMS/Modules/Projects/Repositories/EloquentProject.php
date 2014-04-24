<?php
namespace TypiCMS\Modules\Projects\Repositories;

use Input;
use Config;

use Illuminate\Database\Eloquent\Model;

use TypiCMS\Repositories\RepositoriesAbstract;
use TypiCMS\Modules\Tags\Repositories\TagInterface;

class EloquentProject extends RepositoriesAbstract implements ProjectInterface
{

    protected $tag;

    // Class expects an Eloquent model and a TagInterface
    public function __construct(Model $model, TagInterface $tag)
    {
        $this->model = $model;
        $this->tag = $tag;
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
            isset($data['tags']) and $this->syncTags($model, $data['tags']);

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
        // add checkboxes data
        foreach (Config::get('app.locales') as $locale) {
            $data[$locale]['status'] = Input::get($locale.'.status', 0);
        }

        $model = $this->model->find($data['id']);
        $model->fill($data);
        $model->save();
        isset($data['tags']) and $this->syncTags($model, $data['tags']);

        return true;
    }
}
