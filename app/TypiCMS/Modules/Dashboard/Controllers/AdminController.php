<?php
namespace TypiCMS\Modules\Dashboard\Controllers;

use View;
use TypiCMS\Modules\Dashboard\Repositories\DashboardInterface;
use TypiCMS\Controllers\AdminSimpleController;

class AdminController extends AdminSimpleController
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
        $this->layout->content = View::make('dashboard.admin.dashboard')
            ->with('welcomeMessage', $this->repository->getWelcomeMessage());
    }
}
