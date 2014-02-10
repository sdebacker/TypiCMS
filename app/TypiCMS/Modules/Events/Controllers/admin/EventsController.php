<?php namespace TypiCMS\Modules\Events\Controllers\Admin;

use TypiCMS\Modules\Events\Repositories\EventInterface;
use TypiCMS\Modules\Events\Services\Form\EventForm;

use App\Controllers\Admin\BaseController;

use View;
use Config;
use Input;
use Redirect;
use Request;

class EventsController extends BaseController {

	public function __construct(EventInterface $event, EventForm $eventform)
	{
		parent::__construct($event, $eventform);
		$this->title['parent'] = trans_choice('modules.events.events', 2);
	}

	/**
	 * List models
	 * GET /admin/model
	 */
	public function index()
	{
		$models = $this->repository->getAll(true)->buildList($this->repository->getListProperties());
		$this->title['h1'] = '<span id="nb_elements">'.$models->getTotal().'</span> '.trans_choice('modules.events.events', $models->getTotal());
		$this->layout->content = View::make('events.admin.index')->withModels($models);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$this->title['child'] = trans('modules.events.New');
		$model = $this->repository->getModel();
		$this->layout->content = View::make('events.admin.create')
			->with('model', $model);
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($model)
	{

		$this->title['child'] = trans('modules.events.Edit');
		$this->layout->content = View::make('events.admin.edit')
			->with('model', $model);
	}


	/**
	 * Show resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($model)
	{
		return Redirect::route('admin.events.edit', $model->id);
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{

		if ( $model = $this->form->save( Input::all() ) ) {
			return (Input::get('exit')) ? Redirect::route('admin.events.index') : Redirect::route('admin.events.edit', $model->id) ;
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
	public function update($model)
	{

		Request::ajax() and exit($this->repository->update( Input::all() ));

		$data = Input::all();

		// add checkboxes data
		foreach (Config::get('app.locales') as $locale) {
			$data[$locale]['status'] = Input::get($locale.'.status');
		}

		if ( $this->form->update( $data ) ) {
			return (Input::get('exit')) ? Redirect::route('admin.events.index') : Redirect::route('admin.events.edit', $model->id) ;
		}
		
		return Redirect::route( 'admin.events.edit', $model->id )
			->withInput()
			->withErrors($this->form->errors());

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
	public function destroy($model)
	{
		if( $model->delete() ) {
			if ( ! Request::ajax()) {
				return Redirect::back();
			}
		}
	}


}