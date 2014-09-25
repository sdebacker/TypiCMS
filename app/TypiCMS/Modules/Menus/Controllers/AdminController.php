<?php
namespace TypiCMS\Modules\Menus\Controllers;

use TypiCMS\Controllers\BaseAdminController;
use TypiCMS\Modules\Menus\Repositories\MenuInterface;
use TypiCMS\Modules\Menus\Services\Form\MenuForm;
use View;

class AdminController extends BaseAdminController
{

    public function __construct(MenuInterface $menu, MenuForm $menuform)
    {
        parent::__construct($menu, $menuform);
        $this->title['parent'] = trans_choice('menus::global.menus', 2);
    }

    /**
     * List models
     * GET /admin/model
     */
    public function index()
    {
        $models = $this->repository->getAll(array('translations'), true);

        $this->layout->content = View::make('menus.admin.index')
            ->withModels($models);
    }
}
