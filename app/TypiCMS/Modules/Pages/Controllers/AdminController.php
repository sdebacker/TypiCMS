<?php
namespace TypiCMS\Modules\Pages\Controllers;

use TypiCMS\Controllers\AdminSimpleController;
use TypiCMS\Modules\Pages\Repositories\PageInterface;
use TypiCMS\Modules\Pages\Services\Form\PageForm;
use View;

class AdminController extends AdminSimpleController
{

    public function __construct(PageInterface $page, PageForm $pageform)
    {
        parent::__construct($page, $pageform);
        $this->title['parent'] = trans_choice('pages::global.pages', 2);
    }

    /**
     * List models
     * GET /admin/model
     */
    public function index()
    {
        $models = $this->repository->getAllNested(array('translations'), true);

        $this->layout->content = View::make('pages.admin.index')
            ->withModels($models);
    }
}
