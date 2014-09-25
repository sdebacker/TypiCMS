<?php
namespace TypiCMS\Modules\Events\Controllers;

use TypiCMS\Controllers\BaseApiController;
use TypiCMS\Modules\Events\Repositories\EventInterface as Repository;

class ApiController extends BaseApiController
{
    public function __construct(Repository $repository)
    {
        parent::__construct($repository);
    }
}
