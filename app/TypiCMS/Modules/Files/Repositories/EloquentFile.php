<?php namespace TypiCMS\Modules\Files\Repositories;

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
     * Upoad files
     *
     * @param array  Data to create a new object
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

    public function delete($model)
    {
        if ($model->delete()) {
            return true;
        }
        return false;
    }

}