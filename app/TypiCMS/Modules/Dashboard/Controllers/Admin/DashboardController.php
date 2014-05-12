<?php
namespace TypiCMS\Modules\Dashboard\Controllers\Admin;

use View;

use TypiCMS\Modules\Menus\Models\Menu;
use TypiCMS\Modules\Dashboard\Repositories\DashboardInterface;

use TypiCMS\Controllers\BaseController;

class DashboardController extends BaseController
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

        $modules = $this->repository->getModulesList();

        $this->layout->content = View::make('dashboard.admin.dashboard')
            ->with('welcomeMessage', $this->repository->getWelcomeMessage())
            ->withModules($modules)
            ->withMenus($menus);
    }
}
