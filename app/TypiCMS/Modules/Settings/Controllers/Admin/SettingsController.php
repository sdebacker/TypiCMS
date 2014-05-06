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

        // add checkboxes data
        $data['langChooser'] = Input::get('langChooser', 0);
        $data['authPublic']  = Input::get('authPublic', 0);
        $data['register']    = Input::get('register', 0);
        foreach (Config::get('app.locales') as $locale) {
            $data[$locale]['status'] = Input::get($locale.'.status', 0);
        }

        $this->repository->store($data);

        return Redirect::route('admin.settings.index');

    }
}
