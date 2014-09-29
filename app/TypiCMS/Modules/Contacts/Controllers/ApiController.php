<?php
namespace TypiCMS\Modules\Contacts\Controllers;

use TypiCMS\Controllers\BaseApiController;
use TypiCMS\Modules\Contacts\Repositories\ContactInterface as Repository;

class ApiController extends BaseApiController
{
    public function __construct(Repository $repository)
    {
        parent::__construct($repository);
    }
}
