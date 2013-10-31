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
		$this->title['parent'] = trans_choice('global.modules.pages', 2);
	}


	/**
	 * List models
	 * GET /admin/model
	 */
	public function index()
	{
		$models = $this->repository->getAll(true);
		$list = $this->repository->buildList($models->all());
		$this->layout->content = View::make('admin.pages.index')
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
		$model = $this->repository;
		$this->title['child'] = trans('pages.New');
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
		d($model);
		$this->title['child'] = trans('pages.Edit');
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
		$this->title['child'] = trans('pages.Show');
		$this->layout->content = View::make('admin.pages.show')
			->with('model', $model);
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		// Numeric values must be integer for checkboxes not to be checked.
		// $post = array();
		// foreach (Input::all() as $key => $value) {
		// 	$post[$key] = is_numeric($value) ? (int) $value : $value ;
		// }

		if ( $this->form->save( Input::all() ) ) {
			return Redirect::route('admin.pages.index');
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

		if ( ! Request::ajax()) {
			if ( $this->form->update( Input::all() ) ) {
				return Redirect::route('admin.pages.index');
			}
		} else {
			$this->repository->update( Input::all() );
		}

		if ( ! Request::ajax()) {
			return Redirect::route( 'admin.pages.edit', $model->id )
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
		if( $model->delete() ) {
			if ( ! Request::ajax()) {
				return Redirect::route('admin.pages.index');
			}
		}
	}


}