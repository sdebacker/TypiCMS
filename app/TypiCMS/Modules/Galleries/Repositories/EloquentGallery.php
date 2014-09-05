<?php
namespace TypiCMS\Modules\Galleries\Repositories;

use Illuminate\Database\Eloquent\Model;
use TypiCMS\Repositories\RepositoriesAbstract;
use TypiCMS\Modules\Files\Models\File;

class EloquentGallery extends RepositoriesAbstract implements GalleryInterface
{

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Get all items name
     *
     * @return array with names
     */
    public function getNames()
    {
        return $this->model->lists('name');
    }

    /**
     * Delete model and attached files
     *
     * @return boolean
     */
    public function delete($model)
    {
        if ($model->files) {
            $model->files->each(function (File $file) {
                $file->delete();
            });
        }
        if ($model->delete()) {
            return true;
        }

        return false;
    }
}
