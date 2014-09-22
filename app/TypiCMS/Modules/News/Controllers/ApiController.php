<?php
namespace TypiCMS\Modules\News\Controllers;

use TypiCMS\Controllers\BaseApiController;
use TypiCMS\Modules\News\Repositories\NewsInterface;

class ApiController extends BaseApiController
{
    public function __construct(NewsInterface $news)
    {
        parent::__construct($news);
    }
}
