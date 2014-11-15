<?php
namespace TypiCMS\Modules\Files\Repositories;

use Illuminate\Database\Eloquent\Model;
use stdClass;
use TypiCMS\Repositories\RepositoriesAbstract;

class EloquentFile extends RepositoriesAbstract implements FileInterface
{

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Get paginated models
     *
     * @param  int      $page  Number of models per page
     * @param  int      $limit Results per page
     * @param  model    $gallery_id  from witch gallery ?
     * @param  boolean  $all   get published models or all
     * @param  array    $with  Eager load related models
     * @param  string   $type  file type : a,v,d,i,o
     * @return stdClass Object with $items && $totalItems for pagination
     */
    public function byPageFrom(
        $page = 1,
        $limit = 10,
        $gallery_id = null,
        array $with = array(),
        $all = false,
        $type = null
    ) {
        $result = new stdClass;
        $result->page = $page;
        $result->limit = $limit;
        $result->totalItems = 0;
        $result->items = array();

        $query = $this->make($with);

        if ($type) { // witch type of files to get (a,v,d,i,o) ?
            $query->where('type', $type);
        }

        if ($gallery_id) {
            $query->where('gallery_id', $gallery_id);
        }

        $totalItems = $query->count();

        $query->order()
              ->skip($limit * ($page - 1))
              ->take($limit);

        $models = $query->get();

        // Put items and totalItems in stdClass
        $result->totalItems = $totalItems;
        $result->items = $models->all();

        return $result;
    }
}
