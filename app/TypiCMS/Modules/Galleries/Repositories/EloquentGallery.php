<?php
namespace TypiCMS\Modules\Galleries\Repositories;

use Illuminate\Database\Eloquent\Model;

use TypiCMS\Repositories\RepositoriesAbstract;

class EloquentGallery extends RepositoriesAbstract implements GalleryInterface
{

    // Class expects an Eloquent model
    public function __construct(Model $model)
    {
        $this->model = $model;
    }
}
