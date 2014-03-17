<?php namespace TypiCMS\Modules\Files\Repositories;

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
     * Upload a file
     *
     * @param array input to upload a file
     */
    public function upload(array $input)
    {
        $file = $input['file'];

        $fileName = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME));

        $subdir = str_plural(strtolower(class_basename($input['fileable_type'])));
        $input['path']          = 'uploads/' . $subdir;
        $input['extension']     = '.' . $file->getClientOriginalExtension();
        $input['filesize']      = $file->getClientSize();
        $input['mimetype']      = $file->getClientMimeType();
        $input['filename']      = $fileName . $input['extension'];

        $filecounter = 1;
        while (file_exists($input['path'] . '/' . $input['filename'])) {
            $input['filename'] = $fileName . '_' . $filecounter++ . $input['extension'];
        }

        $upload_success = $file->move($input['path'], $input['filename']);

        if ( $upload_success ) {
            list($input['width'], $input['height']) = getimagesize($input['path'] . '/' . $input['filename']);
            $uploaded = $this->model->create($input);
            // send back id
            echo json_encode(array('id' => $uploaded->id));
            exit();
        } else {
            return Response::json('error', 400);
        }

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