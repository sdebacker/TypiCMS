<?php namespace TypiCMS\Modules\Pages\Controllers\Admin;

use View;
use Input;
use Config;
use Request;
use Redirect;

use TypiCMS\Modules\Pages\Repositories\PageInterface;
use TypiCMS\Modules\Pages\Services\Form\PageForm;

use App\Controllers\Admin\BaseController;

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
		$models = $this->repository->getAll(true);
		$this->layout->content = View::make('pages.admin.index')
			->withModels($models);
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
		$this->layout->content = View::make('pages.admin.create')
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
		// $model = $this->repository->byId($model->id);
		// or
		$model->load('files', 'files.translations');

		$this->title['child'] = trans('modules.pages.Edit');
		$this->layout->content = View::make('pages.admin.edit')
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

		$data = Input::all();

		// add checkboxes data
		$data['rss_enabled']      = Input::get('rss_enabled');
		$data['comments_enabled'] = Input::get('comments_enabled');
		$data['is_home']          = Input::get('is_home');
		foreach (Config::get('app.locales') as $locale) {
			$data[$locale]['status'] = Input::get($locale.'.status');
		}

		if ( $this->form->update( $data ) ) {
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
		if ( $this->repository->delete($model) ) {
			if ( ! Request::ajax()) {
				return Redirect::back();
			}
		}
	}


}