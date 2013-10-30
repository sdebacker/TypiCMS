<?php namespace App\Controllers;

use TypiCMS\Repositories\Project\CategoryInterface;
use View;

class CategoriesController extends BaseController {

	public function __construct(CategoryInterface $category)
	{
		parent::__construct($category);
		$this->title['parent'] = trans_choice('global.modules.categories', 2);
	}


	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$this->title['child'] = '';

		$models = $this->repository->getAll();

		$this->layout->content = View::make('public.'.$this->repository->view().'.index')
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
		
		$this->layout->content = View::make('public.'.$this->repository->view().'.show')
			->with('model', $model);
	}

}