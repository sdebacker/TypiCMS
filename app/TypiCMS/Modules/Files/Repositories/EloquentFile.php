<?php
namespace TypiCMS\Modules\Files\Repositories;

use StdClass;
use Illuminate\Database\Eloquent\Model;
use FileUpload;
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
     * @return StdClass Object with $items && $totalItems for pagination
     */
    public function byPageFrom(
        $page = 1,
        $limit = 10,
        $gallery_id = null,
        array $with = array(),
        $all = false,
        $type = null
    ) {
        $result = new StdClass;
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

    /**
     * Create a new model
     *
     * @param array  Data to create a new model
     * @return boolean
     */
    public function create(array $data)
    {
        if (isset($data['file']) && $data['file']) {
            $path = 'uploads/';
            $file = FileUpload::handle($data['file'], $path);
            $data = array_merge($data, $file);
        }

        // Create the model
        $model = $this->model->fill($data);

        $model->save();

        if (! $model) {
            return false;
        }

        return $model;
    }

    /**
     * Update an existing model
     *
     * @param array  Data to update a model
     * @return boolean
     */
    public function update(array $data)
    {
        if (isset($data['file']) && $data['file']) {
            $path = 'uploads/';
            $file = FileUpload::handle($data['file'], $path);
            $data = array_merge($data, $file);
        }

        $model = $this->model->find($data['id']);

        $model->fill($data);

        $model->save();

        return true;

    }
}
