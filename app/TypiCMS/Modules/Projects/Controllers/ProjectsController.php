<?php namespace TypiCMS\Modules\Projects\Controllers;

use Str;
use View;

use TypiCMS\Modules\Projects\Repositories\ProjectInterface;

// Presenter
use TypiCMS\Presenters\Presenter;
use TypiCMS\Modules\Projects\Presenters\ProjectPresenter;

// Base controller
use App\Controllers\BaseController;

class ProjectsController extends BaseController {

	public function __construct(ProjectInterface $project, Presenter $presenter)
	{
		parent::__construct($project, $presenter);
		$this->title['parent'] = Str::title(trans_choice('projects::global.projects', 2));
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