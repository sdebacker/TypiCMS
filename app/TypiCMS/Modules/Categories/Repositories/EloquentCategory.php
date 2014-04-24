<?php
namespace TypiCMS\Modules\Categories\Repositories;

use Illuminate\Database\Eloquent\Model;

use TypiCMS\Repositories\RepositoriesAbstract;

class EloquentCategory extends RepositoriesAbstract implements CategoryInterface
{

    // Class expects an Eloquent model
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Get all categories
     *
     * @return array
     */
    public function getAllForSelect()
    {
        $query = $this->model->with('translations');

        // take only translated items that are online
        $query->whereHasOnlineTranslation();

        // Get
        $categories = $query->get();

        // Sorting of collection
        $desc = ($this->model->direction == 'desc') ? true : false ;
        $categories = $categories->sortBy(function ($model) {
            return $model->{$this->model->order};
        }, null, $desc);

        $array = array('' => '');
        $categories->each(function ($category) use (&$array) {
            $array[$category->id] = $category->title;
        });

        return $array;

    }
}
