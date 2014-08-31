<?php
namespace TypiCMS\Modules\Dashboard\Controllers;

use View;
use TypiCMS\Modules\Menus\Models\Menu;
use TypiCMS\Modules\Dashboard\Repositories\DashboardInterface;
use TypiCMS\Controllers\BaseAdminController;

class AdminController extends BaseAdminController
{

    public function __construct(DashboardInterface $dashboard)
    {
        parent::__construct($dashboard);
        $this->title['parent'] = trans('dashboard::global.Dashboard');
    }

    /**
     * Admin home
     *
     * @return void
     */
    public function index()
    {
        $menus = Menu::with('translations')->get();

        $this->title['child'] = trans('dashboard::global.Dashboard');

        $this->layout->content = View::make('dashboard.admin.dashboard')
            ->with('welcomeMessage', $this->repository->getWelcomeMessage())
            ->withMenus($menus);
    }
}
