<?php
namespace TypiCMS\Modules\Categories\Repositories;

use Illuminate\Database\Eloquent\Model;
use TypiCMS\Modules\Categories\Models\Category;
use TypiCMS\Repositories\RepositoriesAbstract;

class EloquentCategory extends RepositoriesAbstract implements CategoryInterface
{

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Get all categories for select/option
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
        $categories = $categories->sortBy(function (Model $model) {
            return $model->{$this->model->order};
        }, null, $desc);

        $array = array('' => '');
        $categories->each(function (Category $category) use (&$array) {
            $array[$category->id] = $category->title;
        });

        return $array;

    }

    /**
     * Get all categories and prepare for menu
     *
     * @param  string $uri
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllForMenu($uri = '')
    {
        $categories = $this->getAll();
        $categories->each(function ($category) use ($uri) {
            $category->uri = $uri . '/' . $category->slug;
        });
        return $categories;
    }
}
