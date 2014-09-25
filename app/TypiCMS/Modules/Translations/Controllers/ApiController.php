<?php
namespace TypiCMS\Modules\Translations\Controllers;

use TypiCMS\Controllers\BaseApiController;
use TypiCMS\Modules\Translations\Repositories\TranslationInterface as Repository;

class ApiController extends BaseApiController
{
    public function __construct(Repository $repository)
    {
        parent::__construct($repository);
    }
}
