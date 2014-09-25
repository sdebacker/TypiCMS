<?php
namespace TypiCMS\Modules\Menulinks\Controllers;

use TypiCMS\Controllers\BaseApiController;
use TypiCMS\Modules\Menulinks\Repositories\MenulinkInterface as Repository;

class ApiController extends BaseApiController
{
    public function __construct(Repository $repository)
    {
        parent::__construct($repository);
    }
}
