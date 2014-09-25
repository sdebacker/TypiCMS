<?php
namespace TypiCMS\Modules\Galleries\Controllers;

use TypiCMS\Controllers\BaseApiController;
use TypiCMS\Modules\Galleries\Repositories\GalleryInterface as Repository;

class ApiController extends BaseApiController
{
    public function __construct(Repository $repository)
    {
        parent::__construct($repository);
    }
}
