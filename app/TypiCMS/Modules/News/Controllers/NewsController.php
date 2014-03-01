<?php namespace TypiCMS\Modules\News\Controllers;

use Str;
use View;

use App\Controllers\BaseController;

use TypiCMS\Modules\News\Repositories\NewsInterface;

class NewsController extends BaseController {

	public function __construct(NewsInterface $news)
	{
		parent::__construct($news);
		$this->title['parent'] = Str::title(trans_choice('news::global.news', 2));
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

		$this->layout->content = View::make('news.public.index')
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
		
		$this->layout->content = View::make('news.public.show')
			->with('model', $model);
	}

}