<?php
namespace TypiCMS\Modules\Places\Controllers;

use TypiCMS\Controllers\BaseApiController;
use TypiCMS\Modules\Places\Repositories\PlaceInterface as Repository;

class ApiController extends BaseApiController
{
    public function __construct(Repository $repository)
    {
        parent::__construct($repository);
    }
}
