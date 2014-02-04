<?php namespace App\Controllers\Admin;

use TypiCMS\Repositories\Page\PageInterface;
use TypiCMS\Services\Form\Page\PageForm;
use View;
use Former;
use Input;
use Redirect;
use Request;

class PagesController extends BaseController {

	public function __construct(PageInterface $page, PageForm $pageform)
	{
		parent::__construct($page, $pageform);
		$this->title['parent'] = trans_choice('modules.pages.pages', 2);
	}


	/**
	 * List models
	 * GET /admin/model
	 */
	public function index()
	{
		$models = $this->repository->getAll(true)->buildList($this->repository->getListProperties());
		$this->title['h1'] = '<span id="nb_elements">'.$models->getTotal().'</span> '.trans_choice('modules.pages.pages', $models->getTotal());
		$this->layout->content = View::make('admin.pages.index')->withModels($models);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$model = $this->repository->getModel();
		$this->title['child'] = trans('modules.pages.New');
		$this->layout->content = View::make('admin.pages.create')
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
		$model = $this->repository->byId($model->id);
		// or
		// $model->load('files', 'files.translations');

		$this->title['child'] = trans('modules.pages.Edit');
		$model->setTranslatedFields();
		Former::populate($model);
		$this->layout->content = View::make('admin.pages.edit')
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
		return Redirect::route('admin.pages.edit', $model->id);
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{

		if ( $model = $this->form->save( Input::all() ) ) {
			return (Input::get('exit')) ? Redirect::route('admin.pages.index') : Redirect::route('admin.pages.edit', $model->id) ;
		}

		return Redirect::route('admin.pages.create')
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
			return (Input::get('exit')) ? Redirect::route('admin.pages.index') : Redirect::route('admin.pages.edit', $model->id) ;
		}
		
		return Redirect::route( 'admin.pages.edit', $model->id )
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
		$this->repository->sort( Input::all() );
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($model)
	{
		if ( $model->delete() ) {
			if ( ! Request::ajax()) {
				return Redirect::back();
			}
		}
	}


}