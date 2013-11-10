<?php namespace App\Controllers;

use View;
use TypiCMS\Repositories\Event\EventInterface;

class EventsController extends BaseController {

	public function __construct(EventInterface $event)
	{
		parent::__construct($event);
		$this->title['parent'] = trans_choice('global.modules.events', 2);
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

		$this->layout->content = View::make('public.events.index')
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
		
		$this->layout->content = View::make('public.events.show')
			->with('model', $model)
			->nest('files', 'public.files._list', array('models' => $model->files));
	}

}