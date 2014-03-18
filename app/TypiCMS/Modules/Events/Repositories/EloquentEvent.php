<?php
namespace TypiCMS\Modules\Events\Repositories;

use Illuminate\Database\Eloquent\Model;

use TypiCMS\Repositories\RepositoriesAbstract;

class EloquentEvent extends RepositoriesAbstract implements EventInterface
{

    // Class expects an Eloquent model
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

}
