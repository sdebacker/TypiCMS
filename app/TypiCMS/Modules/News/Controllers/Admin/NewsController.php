<?php namespace TypiCMS\Modules\News\Controllers\Admin;

use View;
use Input;
use Config;
use Request;
use Redirect;

use TypiCMS\Modules\News\Repositories\NewsInterface;
use TypiCMS\Modules\News\Services\Form\NewsForm;

use App\Controllers\Admin\BaseController;

class NewsController extends BaseController {

	public function __construct(NewsInterface $news, NewsForm $newsform)
	{
		parent::__construct($news, $newsform);
		$this->title['parent'] = trans_choice('modules.news.news', 2);
	}

	/**
	 * List models
	 * GET /admin/model
	 */
	public function index()
	{
		$models = $this->repository->getAll(true);
		$this->layout->content = View::make('news.admin.index')->withModels($models);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$this->title['child'] = trans('modules.news.New');
		$model = $this->repository->getModel();
		$this->layout->content = View::make('news.admin.create')
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
		$this->title['child'] = trans('modules.news.Edit');
		$this->layout->content = View::make('news.admin.edit')
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
		return Redirect::route('admin.news.edit', $model->id);
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{

		if ( $model = $this->form->save( Input::all() ) ) {
			return (Input::get('exit')) ? Redirect::route('admin.news.index') : Redirect::route('admin.news.edit', $model->id) ;
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

		Request::ajax() and exit($this->repository->update( Input::all() ));

		$data = Input::all();

		// add checkboxes data
		foreach (Config::get('app.locales') as $locale) {
			$data[$locale]['status'] = Input::get($locale.'.status');
		}

		if ( $this->form->update( $data ) ) {
			return (Input::get('exit')) ? Redirect::route('admin.news.index') : Redirect::route('admin.news.edit', $model->id) ;
		}
		
		return Redirect::route( 'admin.news.edit', $model->id )
			->withInput()
			->withErrors($this->form->errors());
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