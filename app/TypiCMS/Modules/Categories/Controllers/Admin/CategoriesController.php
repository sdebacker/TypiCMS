<?php namespace TypiCMS\Modules\Categories\Controllers\Admin;

use View;
use Input;
use Config;
use Request;
use Redirect;

use TypiCMS\Modules\Categories\Repositories\CategoryInterface;
use TypiCMS\Modules\Categories\Services\Form\CategoryForm;

use App\Controllers\Admin\BaseController;

class CategoriesController extends BaseController {

	public function __construct(CategoryInterface $category, CategoryForm $categoryform)
	{
		parent::__construct($category, $categoryform);
		$this->title['parent'] = trans_choice('modules.categories.categories', 2);
	}

	/**
	 * List models
	 * GET /admin/model
	 */
	public function index()
	{
		$models = $this->repository->getAll(true);
		$this->layout->content = View::make('categories.admin.index')->withModels($models);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$model = $this->repository->getModel();
		$this->title['child'] = trans('modules.categories.New');
		$this->layout->content = View::make('categories.admin.create')
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
		$this->title['child'] = trans('modules.categories.Edit');
		$this->layout->content = View::make('categories.admin.edit')
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
		return Redirect::route('admin.categories.edit', $model->id);
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{

		if ( $model = $this->form->save( Input::all() ) ) {
			return (Input::get('exit')) ? Redirect::route('admin.categories.index') : Redirect::route('admin.categories.edit', $model->id) ;
		}

		return Redirect::route('admin.categories.create')
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

		if ( $this->form->update( $data ) ) {
			return (Input::get('exit')) ? Redirect::route('admin.categories.index') : Redirect::route('admin.categories.edit', $model->id) ;
		}

		return Redirect::route( 'admin.categories.edit', $model->id )
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