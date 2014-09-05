<?php
namespace TypiCMS\Modules\News\Repositories;

use Illuminate\Database\Eloquent\Model;
use TypiCMS\Repositories\RepositoriesAbstract;

class EloquentNews extends RepositoriesAbstract implements NewsInterface
{

    public function __construct(Model $model)
    {
        parent::__construct();
        $this->model = $model;
    }
}
