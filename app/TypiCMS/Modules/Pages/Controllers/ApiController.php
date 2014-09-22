<?php
namespace TypiCMS\Modules\Pages\Controllers;

use TypiCMS\Controllers\BaseApiController;
use TypiCMS\Modules\Pages\Repositories\PageInterface;

class ApiController extends BaseApiController
{
    public function __construct(PageInterface $page)
    {
        parent::__construct($page);
    }
}
