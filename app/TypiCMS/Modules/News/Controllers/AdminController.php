<?php
namespace TypiCMS\Modules\News\Controllers;

use Str;
use TypiCMS\Modules\News\Repositories\NewsInterface;
use TypiCMS\Modules\News\Services\Form\NewsForm;
use TypiCMS\Controllers\BaseAdminController;

class AdminController extends BaseAdminController
{

    public function __construct(NewsInterface $news, NewsForm $newsform)
    {
        parent::__construct($news, $newsform);
        $this->title['parent'] = Str::title(trans_choice('news::global.news', 2));
    }
}
