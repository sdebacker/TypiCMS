<?php
namespace TypiCMS\Modules\Pages\Controllers;

use TypiCMS\Controllers\AdminSimpleController;
use TypiCMS\Modules\Pages\Repositories\PageInterface;
use TypiCMS\Modules\Pages\Services\Form\PageForm;

class AdminController extends AdminSimpleController
{

    public function __construct(PageInterface $page, PageForm $pageform)
    {
        parent::__construct($page, $pageform);
        $this->title['parent'] = trans_choice('pages::global.pages', 2);
    }
}
