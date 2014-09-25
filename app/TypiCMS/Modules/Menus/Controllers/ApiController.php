<?php
namespace TypiCMS\Modules\Menus\Controllers;

use TypiCMS\Controllers\BaseApiController;
use TypiCMS\Modules\Menus\Repositories\MenuInterface as Repository;

class ApiController extends BaseApiController
{
    public function __construct(Repository $repository)
    {
        parent::__construct($repository);
    }
}
