<?php
namespace TypiCMS\Modules\Files\Controllers;

use TypiCMS\Controllers\BaseApiController;
use TypiCMS\Modules\Files\Repositories\FileInterface as Repository;

class ApiController extends BaseApiController
{
    public function __construct(Repository $repository)
    {
        parent::__construct($repository);
    }
}
