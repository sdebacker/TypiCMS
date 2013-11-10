<?php namespace App\Controllers;

use View;
use TypiCMS\Repositories\News\NewsInterface;

class NewsController extends BaseController {

	public function __construct(NewsInterface $news)
	{
		parent::__construct($news);
		$this->title['parent'] = trans_choice('global.modules.news', 2);
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

		$this->layout->content = View::make('public.news.index')
			->with('models', $models);
	}

	/**
	 * Show news.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($slug)
	{
		$model = $this->repository->bySlug($slug);

		$this->title['parent'] = $model->title;
		
		$this->layout->content = View::make('public.news.show')
			->with('model', $model)
			->nest('files', 'public.files._list', array('models' => $model->files));
	}

}