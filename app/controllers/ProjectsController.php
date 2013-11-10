<?php namespace App\Controllers;

use TypiCMS\Repositories\Project\ProjectInterface;
use View;

class ProjectsController extends BaseController {

	public function __construct(ProjectInterface $project)
	{
		parent::__construct($project);
		$this->title['parent'] = trans_choice('global.modules.projects', 2);
	}


	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index($category = null)
	{
		$this->title['child'] = '';

		$category_id = $category ? $category->id : null ;
		$models = $this->repository->getAll(false, $category_id);

		$this->layout->content = View::make('public.projects.index')
			->with('category', $category)
			->with('models', $models);
	}


	/**
	 * Show resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($category = null, $slug = null)
	{
		$model = $this->repository->bySlug($slug);

		$this->title['parent'] = $model->title;
		
		$this->layout->content = View::make('public.projects.show')
			->with('model', $model)
			->nest('files', 'public.files._list', array('models' => $model->files));
	}

}