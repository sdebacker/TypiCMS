<?php
namespace TypiCMS\Modules\Settings\Controllers\Admin;

use View;
use Input;
use Config;
use Redirect;

use TypiCMS\Modules\Settings\Repositories\SettingInterface;

use TypiCMS\Controllers\BaseController;

class SettingsController extends BaseController
{

    public function __construct(SettingInterface $setting)
    {
        parent::__construct($setting);
        $this->title['parent'] = ucfirst(trans('global.settings'));
    }

    /**
     * List models
     * GET /admin/model
     */
    public function index()
    {
        $data = $this->repository->getAll(array(), true);
        $this->layout->content = View::make('settings.admin.index')
            ->withData($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        $data = Input::all();

        $this->repository->store($data);

        return Redirect::route('admin.settings.index');

    }
}
