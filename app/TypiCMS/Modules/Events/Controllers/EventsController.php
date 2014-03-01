<?php namespace TypiCMS\Modules\Events\Controllers;

use Str;
use View;

use TypiCMS\Modules\Events\Repositories\EventInterface;

use App\Controllers\BaseController;

class EventsController extends BaseController {

	public function __construct(EventInterface $event)
	{
		parent::__construct($event);
		$this->title['parent'] = Str::title(trans_choice('events::global.events', 2));
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

		$this->layout->content = View::make('events.public.index')
			->with('models', $models);
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
		
		$this->layout->content = View::make('events.public.show')
			->with('model', $model);
	}

}