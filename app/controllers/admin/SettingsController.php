<?php namespace App\Controllers\Admin;

use TypiCMS\Repositories\Setting\SettingInterface;

use View;
use Input;
use Config;
use Request;
use Redirect;

class SettingsController extends BaseController {

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
		$data = $this->repository->getAll(true);
		$this->layout->content = View::make('admin.settings.index')
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
		$data['langChooser'] = (int) Input::get('langChooser');
		$data['authPublic']  = (int) Input::get('authPublic');
		$data['register']    = (int) Input::get('register');
		foreach (Config::get('app.locales') as $locale) {
			$data[$locale]['websiteTitle'] = Input::get($locale.'.websiteTitle');
			$data[$locale]['status'] = Input::get($locale.'.status') ? (int) Input::get($locale.'.status') : null;
		}

		$this->repository->store( $data );
		return Redirect::route('admin.settings.index');

	}


}