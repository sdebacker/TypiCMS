<?php namespace TypiCMS\Modules\Projects\Controllers;

use View;

use TypiCMS\Modules\Projects\Repositories\ProjectInterface;

use App\Controllers\BaseController;

class ProjectsController extends BaseController {

	public function __construct(ProjectInterface $project)
	{
		parent::__construct($project);
		$this->title['parent'] = trans_choice('modules.projects.projects', 2);
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

		$this->layout->content = View::make('projects.public.index')
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
		
		$this->layout->content = View::make('projects.public.show')
			->with('model', $model);
	}

}