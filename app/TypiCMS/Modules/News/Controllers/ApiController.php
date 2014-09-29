<?php
namespace TypiCMS\Modules\News\Controllers;

use TypiCMS\Controllers\BaseApiController;
use TypiCMS\Modules\News\Repositories\NewsInterface as Repository;

class ApiController extends BaseApiController
{
    public function __construct(Repository $repository)
    {
        parent::__construct($repository);
    }
}
