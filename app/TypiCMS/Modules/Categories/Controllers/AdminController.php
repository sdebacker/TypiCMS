<?php
namespace TypiCMS\Modules\Categories\Controllers;

use TypiCMS\Controllers\AdminSimpleController;
use TypiCMS\Modules\Categories\Repositories\CategoryInterface;
use TypiCMS\Modules\Categories\Services\Form\CategoryForm;
use View;

class AdminController extends AdminSimpleController
{

    public function __construct(CategoryInterface $category, CategoryForm $categoryform)
    {
        parent::__construct($category, $categoryform);
        $this->title['parent'] = trans_choice('categories::global.categories', 2);
    }

    /**
     * List models
     * GET /admin/model
     */
    public function index()
    {
        $models = $this->repository->getAll(array('translations', 'projects'), true);

        $this->layout->content = View::make('categories.admin.index')->withModels($models);
    }
}
