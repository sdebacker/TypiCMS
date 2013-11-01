<?php namespace App\Controllers\Admin;

use TypiCMS\Repositories\Configuration\ConfigurationInterface;
use View;
use Former;
use Input;
use Redirect;
use Request;

class ConfigurationController extends BaseController {

	public function __construct(ConfigurationInterface $configuration)
	{
		parent::__construct($configuration);
		$this->title['parent'] = trans_choice('global.modules.configurations', 2);
	}


	/**
	 * List models
	 * GET /admin/model
	 */
	public function index()
	{
		$datas = $this->repository->getAll(true);
		Former::populate($datas);
		$this->layout->content = View::make('admin.configuration.index');
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{

		if ( $this->repository->create( Input::all() ) ) {
			return Redirect::route('admin.configuration.index');
		}

		return Redirect::route('admin.configuration.index')
			->withInput();

	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($model)
	{

		$this->repository->update( Input::all() );
		return Redirect::route('admin.configuration.index')->withInput();

	}


}