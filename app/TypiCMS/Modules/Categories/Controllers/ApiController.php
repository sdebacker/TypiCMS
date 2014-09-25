<?php
namespace TypiCMS\Modules\Categories\Controllers;

use TypiCMS\Controllers\BaseApiController;
use TypiCMS\Modules\Categories\Repositories\CategoryInterface as Repository;

class ApiController extends BaseApiController
{
    public function __construct(Repository $repository)
    {
        parent::__construct($repository);
    }
}
