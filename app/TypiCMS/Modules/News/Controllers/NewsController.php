<?php namespace TypiCMS\Modules\News\Controllers;

use Str;
use View;
use Input;
use Paginator;

use App\Controllers\BaseController;

use TypiCMS\Modules\News\Repositories\NewsInterface;

use TypiCMS\Modules\News\Presenters\NewsPresenter;
use TypiCMS\Presenters\Presenter;

class NewsController extends BaseController {

	public function __construct(NewsInterface $news, Presenter $presenter)
	{
		parent::__construct($news, $presenter);
		$this->title['parent'] = Str::title(trans_choice('news::global.news', 2));
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$page = Input::get('page');

		$itemsPerPage = 10;
		$data = $this->repository->byPage($page, $itemsPerPage);

		$models = Paginator::make($data->items, $data->totalItems, $itemsPerPage);

		$models = $this->presenter->paginator($models, new NewsPresenter);

		$this->layout->content = View::make('news.public.index')->withModels($models);
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

		$model = $this->presenter->model($model, new NewsPresenter);
		
		$this->layout->content = View::make('news.public.show')
			->withModel($model);
	}

}