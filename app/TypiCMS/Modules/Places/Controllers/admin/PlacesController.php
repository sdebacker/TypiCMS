<?php namespace TypiCMS\Modules\Places\Controllers\Admin;

use TypiCMS\Modules\Places\Repositories\PlaceInterface;
use TypiCMS\Modules\Places\Services\Form\PlaceForm;

use App\Controllers\Admin\BaseController;

use View;
use Former;
use Input;
use Redirect;
use Request;

class PlacesController extends BaseController {

	public function __construct(PlaceInterface $place, PlaceForm $placeform)
	{
		parent::__construct($place, $placeform);
		$this->title['parent'] = trans_choice('modules.places.places', 2);
	}

	/**
	 * List models
	 * GET /admin/model
	 */
	public function index()
	{

		$page = Input::get('page');

		$itemsPerPages = $this->repository->getModel()->itemsPerPage;

		$collection = $this->repository->byPage($page, $itemsPerPages, true);
		$array = $collection->getCollection()->all();

		$models = new \TypiCMS\NestedCollection($array);

		$modelse = $models->buildList($this->repository->getListProperties());

		$this->layout->content = View::make('places.admin.index')
			->withCollection($collection)
			->withModels($modelse);


	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$this->title['child'] = trans('modules.places.New');
		$model = $this->repository->getModel();
		$this->layout->content = View::make('places.admin.create')
			->withModel($model);
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($model)
	{
		$this->title['child'] = trans('modules.places.Edit');
		Former::populate($model);
		$this->layout->content = View::make('places.admin.edit')
			->withModel($model);
	}


	/**
	 * Show resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($model)
	{
		return Redirect::route('admin.places.edit', $model->id);
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{

		if ( $model = $this->form->save( Input::all() ) ) {
			return (Input::get('exit')) ? Redirect::route('admin.places.index') : Redirect::route('admin.places.edit', $model->id) ;
		}

		return Redirect::route('admin.places.create')
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

		if ( $this->form->update( Input::all() ) ) {
			return (Input::get('exit')) ? Redirect::route('admin.places.index') : Redirect::route('admin.places.edit', $model->id) ;
		}

		return Redirect::route( 'admin.places.edit', $model->id )
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