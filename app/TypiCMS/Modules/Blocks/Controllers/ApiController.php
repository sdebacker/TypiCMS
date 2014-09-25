<?php
namespace TypiCMS\Modules\Blocks\Controllers;

use TypiCMS\Controllers\BaseApiController;
use TypiCMS\Modules\Blocks\Repositories\BlockInterface as Repository;

class ApiController extends BaseApiController
{
    public function __construct(Repository $repository)
    {
        parent::__construct($repository);
    }
}
