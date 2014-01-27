<?php namespace App\Controllers\Admin;

use TypiCMS\Repositories\Project\ProjectInterface;
use TypiCMS\Services\Form\Project\ProjectForm;
use View;
use Former;
use Input;
use Redirect;
use Request;

class ProjectsController extends BaseController {

	public function __construct(ProjectInterface $project, ProjectForm $projectform)
	{
		parent::__construct($project, $projectform);
		$this->title['parent'] = trans_choice('modules.projects.projects', 2);
	}

	/**
	 * List models
	 * GET /admin/model
	 */
	public function index()
	{
		$models = $this->repository->getAll(true)->buildList($this->repository->getListProperties());
		$this->title['h1'] = '<span id="nb_elements">'.$models->getTotal().'</span> '.trans_choice('modules.projects.projects', $models->getTotal());
		$this->layout->content = View::make('admin.projects.index')->withModels($models);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$model = $this->repository;
		$this->title['child'] = trans('modules.projects.New');
		$this->layout->content = View::make('admin.projects.create')
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
		$model = $this->repository->byId($model->id);

		$this->title['child'] = trans('modules.projects.Edit');
		$model->setTranslatedFields();
		Former::populate($model);
		$this->layout->content = View::make('admin.projects.edit')
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
		return Redirect::route('admin.projects.edit', $model->id);
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{

		if ( $this->form->save( Input::all() ) and Input::get('exit') ) {
			return Redirect::route('admin.projects.index');
		}

		return Redirect::route('admin.projects.create')
			->withInput()
			->withErrors($this->form->errors());

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
			if ( $this->form->update( Input::all() ) and Input::get('exit') ) {
				return Redirect::route('admin.projects.index');
			}
		} else {
			$this->repository->update( Input::all() );
		}

		if ( ! Request::ajax()) {
			return Redirect::route( 'admin.projects.edit', $model->id )
				->withInput()
				->withErrors($this->form->errors());
		}
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function sort()
	{
		$sort = $this->repository->sort( Input::all() );
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($model)
	{
		if( $model->delete() ) {
			if ( ! Request::ajax()) {
				return Redirect::back();
			}
		}
	}


}