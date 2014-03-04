<?php namespace TypiCMS\Modules\Translations\Controllers\Admin;

use App;
use View;
use Input;
use Config;
use Request;
use Session;
use Redirect;

use Illuminate\Support\Collection;

use TypiCMS\Modules\Translations\Repositories\TranslationInterface;
use TypiCMS\Modules\Translations\Services\Form\TranslationForm;

// Presenter
use TypiCMS\Presenters\Presenter;
use TypiCMS\Modules\Translations\Presenters\TranslationPresenter;

// Base controller
use App\Controllers\Admin\BaseController;

class TranslationsController extends BaseController {

	public function __construct(TranslationInterface $translation, TranslationForm $translationform, Presenter $presenter)
	{
		parent::__construct($translation, $translationform, $presenter);
		$this->title['parent'] = trans_choice('translations::global.translations', 2);
	}

	/**
	 * List models
	 * GET /admin/model
	 */
	public function index()
	{
		$models = Collection::make($this->repository->getAll(true));

		$models = $this->presenter->collection($models, new TranslationPresenter);

		$this->layout->content = View::make('translations.admin.index')
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

		$this->title['child'] = trans('translations::global.New');
		$this->layout->content = View::make('translations.admin.create')
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

		$this->title['child'] = trans('translations::global.Edit');

		$this->layout->content = View::make('translations.admin.edit')
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
		return Redirect::route('admin.translations.edit', $model->id);
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{

		if ( $model = $this->form->save( Input::all() ) ) {
			return (Input::get('exit')) ? Redirect::route('admin.translations.index') : Redirect::route('admin.translations.edit', $model->id) ;
		}

		return Redirect::route('admin.translations.create')
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
			return (Input::get('exit')) ? Redirect::route('admin.translations.index') : Redirect::route('admin.translations.edit', $model->id) ;
		}
		
		return Redirect::route( 'admin.translations.edit', $model->id )
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
		if ( $this->repository->delete($model) ) {
			if ( ! Request::ajax()) {
				return Redirect::back();
			}
		}
	}


}