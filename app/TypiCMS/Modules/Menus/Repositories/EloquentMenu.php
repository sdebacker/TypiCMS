<?php namespace TypiCMS\Modules\Menus\Repositories;

use Illuminate\Database\Eloquent\Model;

use TypiCMS\Repositories\RepositoriesAbstract;

class EloquentMenu extends RepositoriesAbstract implements MenuInterface
{

    // Class expects an Eloquent model
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Get all models
     *
     * @param boolean $all Show published or all
     * @return StdClass Object with $items
     */
    public function getAll($all = false, $relatedModel = null)
    {
        return $this->model->with('translations')
                           ->with('menulinks')
                           ->order()
                           ->get();
    }

}