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

}