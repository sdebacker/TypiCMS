<?php
namespace TypiCMS\Modules\Pages\Controllers;

use TypiCMS\Controllers\BaseApiController;
use TypiCMS\Modules\Pages\Repositories\PageInterface as Repository;

class ApiController extends BaseApiController
{
    public function __construct(Repository $repository)
    {
        parent::__construct($repository);
    }
}
