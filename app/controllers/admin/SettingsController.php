<?php namespace App\Controllers\Admin;

use TypiCMS\Repositories\Setting\SettingInterface;
use View;
use Input;
use Redirect;
use Request;

class SettingsController extends BaseController {

	public function __construct(SettingInterface $setting)
	{
		parent::__construct($setting);
		$this->title['parent'] = trans('global.settings');
	}


	/**
	 * List models
	 * GET /admin/model
	 */
	public function index()
	{
		$datas = $this->repository->getAll(true);
		Former::populate($datas);
		$this->title['h1'] = ucfirst(trans('global.settings'));
		$this->layout->content = View::make('admin.settings.index');
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{

		$this->repository->store( Input::all() );
		return Redirect::route('admin.settings.index');

	}


}