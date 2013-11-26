<?php namespace App\Controllers\Admin;

use TypiCMS\Repositories\Event\EventInterface;
use TypiCMS\Services\Form\Event\EventForm;
use View;
use Former;
use Input;
use Redirect;
use Request;

class EventsController extends BaseController {

	public function __construct(EventInterface $event, EventForm $eventform)
	{
		parent::__construct($event, $eventform);
		$this->title['parent'] = trans_choice('global.modules.events', 2);
	}

	/**
	 * List models
	 * GET /admin/model
	 */
	public function index()
	{
		$models = $this->repository->getAll(true);
		$list = $this->repository->buildList($models->all());
		$this->layout->content = View::make('admin.events.index')
			->with('models', $models)
			->with('list', $list);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$this->title['child'] = trans('events.New');
		$model = $this->repository;
		$this->layout->content = View::make('admin.events.create')
			->with('model', $model);
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$model = $this->repository->byId($id);

		$this->title['child'] = trans('events.Edit');
		$model->setTranslatedFields();
		Former::populate($model);
		$this->layout->content = View::make('admin.events.edit')
			->with('model', $model);
	}


	/**
	 * Show resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$model = $this->repository->byId($id);

		$this->title['child'] = trans('events.Show');
		$this->layout->content = View::make('admin.events.show')
			->with('model', $model);
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{

		if ( $this->form->save( Input::all() ) ) {
			return Redirect::route('admin.events.index');
		}

		return Redirect::route('admin.events.create')
			->withInput()
			->withErrors($this->form->errors());

	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$model = $this->repository->byId($id);

		if ( ! Request::ajax()) {
			if ( $this->form->update( Input::all() ) ) {
				return Redirect::route('admin.events.index');
			}
		} else {
			$this->repository->update( Input::all() );
		}

		if ( ! Request::ajax()) {
			return Redirect::route( 'admin.events.edit', $model->id )
				->withInput()
				->withErrors($this->form->errors());
		}
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function sort()
	{
		$sort = $this->repository->sort( Input::all() );
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$model = $this->repository->byId($id);

		if( $model->delete() ) {
			if ( ! Request::ajax()) {
				return Redirect::back();
			}
		}
	}


}