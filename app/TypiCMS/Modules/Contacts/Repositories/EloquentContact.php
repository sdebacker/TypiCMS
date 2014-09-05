<?php
namespace TypiCMS\Modules\Contacts\Repositories;

use Illuminate\Database\Eloquent\Model;
use TypiCMS\Repositories\RepositoriesAbstract;

class EloquentContact extends RepositoriesAbstract implements ContactInterface
{

    public function __construct(Model $model)
    {
        $this->model = $model;
    }
}
