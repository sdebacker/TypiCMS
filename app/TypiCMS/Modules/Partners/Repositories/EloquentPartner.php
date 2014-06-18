<?php
namespace TypiCMS\Modules\Partners\Repositories;

use StdClass;

use App;
use Input;
use Config;
use Croppa;
use Request;

use FileUpload;

use Illuminate\Database\Eloquent\Model;

use TypiCMS\Repositories\RepositoriesAbstract;

class EloquentPartner extends RepositoriesAbstract implements PartnerInterface
{

    // Class expects an Eloquent model
    public function __construct(Model $model)
    {
        $this->model = $model;
    }
}
