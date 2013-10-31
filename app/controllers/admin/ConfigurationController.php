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
		$models = $this->repository->getAll(true);
		$this->layout->content = View::make('admin.configuration.index')
			->with('models', $models);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$model = $this->repository;
		$this->title['child'] = trans('configurations.New');
		$this->layout->content = View::make('admin.configuration.create')
			->with('model', $model);
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($model)
	{
		$this->title['child'] = trans('configurations.Edit');
		$model->setTranslatedFields();
		Former::populate($model);
		$this->layout->content = View::make('admin.configuration.edit')
			->with('model', $model);
	}


	/**
	 * Show resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($model)
	{
		$this->title['child'] = trans('configurations.Show');
		$this->layout->content = View::make('admin.configuration.show')
			->with('model', $model);
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{

		if ( $this->repository->create( $post ) ) {
			return Redirect::route('admin.configuration.index');
		}

		return Redirect::route('admin.configuration.index')
			->withInput($post);

	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($model)
	{

		if ( ! Request::ajax()) {
			if ( $this->repository->update( Input::all() ) ) {
				return Redirect::route('admin.configuration.index');
			}
		} else {
			$this->repository->update( Input::all() );
		}

		if ( ! Request::ajax()) {
			return Redirect::route( 'admin.configuration.edit', $model->id )
				->withInput();
		}
	}


}