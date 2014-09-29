<?php
namespace TypiCMS\Modules\Users\Controllers;

use TypiCMS\Controllers\BaseApiController;
use TypiCMS\Modules\Users\Repositories\UserInterface as Repository;

class ApiController extends BaseApiController
{
    public function __construct(Repository $repository)
    {
        parent::__construct($repository);
    }
}
