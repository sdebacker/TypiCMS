<?php namespace TypiCMS\Modules\Events\Controllers;

use Str;
use View;
use Input;
use Paginator;

use TypiCMS\Modules\Events\Repositories\EventInterface;

// Presenter
use TypiCMS\Presenters\Presenter;
use TypiCMS\Modules\Events\Presenters\EventPresenter;

// Base controller
use App\Controllers\BaseController;

class EventsController extends BaseController {

	public function __construct(EventInterface $event, Presenter $presenter)
	{
		parent::__construct($event, $presenter);
		$this->title['parent'] = Str::title(trans_choice('events::global.events', 2));
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

		$models = $this->presenter->paginator($models, new EventPresenter);

		$this->layout->content = View::make('events.public.index')->withModels($models);
	}


	/**
	 * Show event.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($slug)
	{
		$model = $this->repository->bySlug($slug);

		$this->title['parent'] = $model->title;

		$model = $this->presenter->model($model, new EventPresenter);
		
		$this->layout->content = View::make('events.public.show')
			->withModel($model);
	}

}