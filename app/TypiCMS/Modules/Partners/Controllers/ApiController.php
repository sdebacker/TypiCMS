<?php
namespace TypiCMS\Modules\Partners\Controllers;

use TypiCMS\Controllers\BaseApiController;
use TypiCMS\Modules\Partners\Repositories\PartnerInterface as Repository;

class ApiController extends BaseApiController
{
    public function __construct(Repository $repository)
    {
        parent::__construct($repository);
    }
}
