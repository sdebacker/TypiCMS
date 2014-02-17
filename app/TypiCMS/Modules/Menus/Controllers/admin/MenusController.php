<?php namespace TypiCMS\Modules\Menus\Controllers\Admin;

use View;
use Input;
use Config;
use Request;
use Redirect;

use TypiCMS\Modules\Menus\Repositories\MenuInterface;
use TypiCMS\Modules\Menus\Services\Form\MenuForm;

use App\Controllers\Admin\BaseController;

class MenusController extends BaseController {

	public function __construct(MenuInterface $menu, MenuForm $menuform)
	{
		parent::__construct($menu, $menuform);
		$this->title['parent'] = trans_choice('modules.menus.menus', 2);
	}


	/**
	 * List models
	 * GET /admin/model
	 */
	public function index()
	{
		$models = $this->repository->getAll(true);
		$this->layout->content = View::make('menus.admin.index')
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
		$this->title['child'] = trans('modules.menus.New');
		$this->layout->content = View::make('menus.admin.create')
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
		$this->title['child'] = trans('modules.menus.Edit');
		$this->layout->content = View::make('menus.admin.edit')
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
		return Redirect::route('admin.menus.edit', $model->id);
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{

		if ( $model = $this->form->save( Input::all() ) ) {
			return (Input::get('exit')) ? Redirect::route('admin.menus.index') : Redirect::route('admin.menus.edit', $model->id) ;
		}

		return Redirect::route('admin.menus.create')
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
			return (Input::get('exit')) ? Redirect::route('admin.menus.index') : Redirect::route('admin.menus.edit', $model->id) ;
		}
		
		return Redirect::route( 'admin.menus.edit', $model->id )
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