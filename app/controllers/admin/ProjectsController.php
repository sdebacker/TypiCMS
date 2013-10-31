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
		$this->title['parent'] = trans_choice('global.modules.projects', 2);
	}

	/**
	 * List models
	 * GET /admin/model
	 */
	public function index($category)
	{
		$models = $this->repository->getAll(true, $category->id);
		$list = $this->repository->buildList($models->all());
		$this->layout->content = View::make('admin.projects.index')
			->with('category', $category)
			->with('models', $models)
			->with('list', $list);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create($category)
	{
		$model = $this->repository;
		$this->title['child'] = trans('projects.New');
		$this->layout->content = View::make('admin.projects.create')
			->with('category', $category)
			->with('model', $model);
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($category, $model)
	{
		$this->title['child'] = trans('projects.Edit');
		$model->setTranslatedFields();
		Former::populate($model);
		$this->layout->content = View::make('admin.projects.edit')
			->with('category', $category)
			->with('model', $model);
	}


	/**
	 * Show resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($category, $model)
	{
		$this->title['child'] = trans('projects.Show');
		$this->layout->content = View::make('admin.projects.show')
			->with('category', $category)
			->with('model', $model);
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store($category)
	{

		if ( $this->form->save( $post ) ) {
			return Redirect::route('admin.categories.projects.index', $category->id);
		}

		return Redirect::route('admin.categories.projects.create', $category->id)
			->withInput($post)
			->withErrors($this->form->errors());

	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($category, $model)
	{

		if ( ! Request::ajax()) {
			if ( $this->form->update( Input::all() ) ) {
				return Redirect::route('admin.categories.projects.index', $category->id);
			}
		} else {
			$this->repository->update( Input::all() );
		}

		if ( ! Request::ajax()) {
			return Redirect::route( 'admin.categories.projects.edit', array($category->id, $model->id) )
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
	public function destroy($category, $model)
	{
		if( $model->delete() ) {
			if ( ! Request::ajax()) {
				return Redirect::route('admin.categories.projects.index', $category->id);
			}
		}
	}


}