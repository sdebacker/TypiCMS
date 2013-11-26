<?php namespace App\Controllers\Admin;

use TypiCMS\Repositories\News\NewsInterface;
use TypiCMS\Services\Form\News\NewsForm;
use View;
use Former;
use Input;
use Redirect;
use Request;

class NewsController extends BaseController {

	public function __construct(NewsInterface $news, NewsForm $newsform)
	{
		parent::__construct($news, $newsform);
		$this->title['parent'] = trans_choice('global.modules.news', 2);
	}

	/**
	 * List models
	 * GET /admin/model
	 */
	public function index()
	{
		$models = $this->repository->getAll(true);
		$list = $this->repository->buildList($models->all());
		$this->layout->content = View::make('admin.news.index')
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
		$this->title['child'] = trans('news.New');
		$model = $this->repository;
		$this->layout->content = View::make('admin.news.create')
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
		$this->title['child'] = trans('news.Edit');
		$model->setTranslatedFields();
		Former::populate($model);
		$this->layout->content = View::make('admin.news.edit')
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
		$this->title['child'] = trans('news.Show');
		$this->layout->content = View::make('admin.news.show')
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
			return Redirect::route('admin.news.index');
		}

		return Redirect::route('admin.news.create')
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
				return Redirect::route('admin.news.index');
			}
		} else {
			$this->repository->update( Input::all() );
		}

		if ( ! Request::ajax()) {
			return Redirect::route( 'admin.news.edit', $model->id )
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
	public function destroy($model)
	{
		if( $model->delete() ) {
			if ( ! Request::ajax()) {
				return Redirect::back();
			}
		}
	}


}