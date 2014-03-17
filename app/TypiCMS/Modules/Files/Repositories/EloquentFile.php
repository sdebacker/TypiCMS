<?php
namespace TypiCMS\Modules\Files\Repositories;

use StdClass;

use Str;
use Input;
use Croppa;
use Response;

use TypiCMS\Repositories\RepositoriesAbstract;
use Illuminate\Database\Eloquent\Model;

class EloquentFile extends RepositoriesAbstract implements FileInterface
{


    // Class expects an Eloquent model
    public function __construct(Model $model)
    {
        $this->model = $model;
    }


    /**
     * Get paginated models
     *
     * @param int $page Number of models per page
     * @param int $limit Results per page
     * @param model $from related model
     * @param boolean $all get published models or all
     * @param array $with Eager load related models
     * @return StdClass Object with $items and $totalItems for pagination
     */
    public function byPageFrom($page = 1, $limit = 10, $from, array $with = array(), $all = false)
    {
        $result = new StdClass;
        $result->page = $page;
        $result->limit = $limit;
        $result->totalItems = 0;
        $result->items = array();

        $query = $this->make($with);

        if ($from) {
            $query->where('fileable_id', $from->id)
                  ->where('fileable_type', get_class($from));
        }

        $totalItems = $query->count();

        $query->order()
              ->skip($limit * ($page - 1))
              ->take($limit);

        $models = $query->get();

        // Put items and totalItems in StdClass
        $result->totalItems = $totalItems;
        $result->items = $models->all();

        return $result;
    }


    /**
     * Delete model
     *
     * @return boolean
     */
    public function delete($model)
    {
        if ($model->delete()) {
            return true;
        }
        return false;
    }

}