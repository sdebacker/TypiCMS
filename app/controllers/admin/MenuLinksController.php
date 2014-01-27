<?php namespace App\Controllers\Admin;

use TypiCMS\Repositories\Menulink\MenulinkInterface;
use TypiCMS\Services\Form\Menulink\MenulinkForm;
use Lang;
use View;
use Former;
use Validator;
use Input;
use Redirect;
use Request;
use Config;

class MenuLinksController extends BaseController {

	public function __construct(MenulinkInterface $menulink, MenulinkForm $menulinkform)
	{
		parent::__construct($menulink, $menulinkform);
		$this->title['parent'] = Lang::choice('modules.menulinks.menulinks', 2);
		// $this->model = $menulink;
	}

	/**
	 * List models
	 * GET /admin/model
	 */
	public function index($menu)
	{
		$models = $this->repository->getAllFromMenu(true, $menu->id)->buildList($this->repository->getListProperties());
		$this->title['h1'] = '<span id="nb_elements">'.$models->getTotal().'</span> '.trans_choice('modules.menulinks.menulinks', $models->getTotal());
		$this->layout->content = View::make('admin.menulinks.index')->withModels($models)->withMenu($menu);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create($menu)
	{
		$model = $this->repository;
		$this->title['child'] = trans('modules.menulinks.New');

		$selectPages = $this->repository->getPagesForSelect();
		$selectModules = $this->repository->getModulesForSelect();

		$this->layout->content = View::make('admin.menulinks.create')
			->with('menu', $menu)
			->with('selectPages', $selectPages)
			->with('selectModules', $selectModules)
			->with('model', $model);
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($menu, $model)
	{
		$this->title['child'] = trans('modules.menulinks.Edit');
		$model->setTranslatedFields();

		$selectPages = $this->repository->getPagesForSelect();
		$selectModules = $this->repository->getModulesForSelect();

		Former::populate($model);

		$this->layout->content = View::make('admin.menulinks.edit', array($menu->id, $model->id))
			->with('menu', $menu)
			->with('selectPages', $selectPages)
			->with('selectModules', $selectModules)
			->with('model', $model);
	}


	/**
	 * Show resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($menu, $model)
	{
		return Redirect::route('admin.menus.menulinks.edit', array($menu->id, $model->id));
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store($menu)
	{

		if ( $this->form->save( Input::all() ) and Input::get('exit') ) {
			return Redirect::route('admin.menus.menulinks.index', $menu->id);
		}

		return Redirect::route('admin.menus.menulinks.create', $menu->id)
			->withInput()
			->withErrors($this->form->errors());

	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($menu, $model)
	{

		if ( ! Request::ajax()) {
			if ( $this->form->update( Input::all() ) and Input::get('exit') ) {
				return Redirect::route('admin.menus.menulinks.index', $menu->id);
			}
		} else {
			$this->repository->update( Input::all() );
		}

		if ( ! Request::ajax()) {
			return Redirect::route( 'admin.menus.menulinks.edit', array($menu->id, $model->id) )
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
	public function destroy($menu, $model)
	{
		if( $model->delete() ) {
			if ( ! Request::ajax()) {
				return Redirect::back();
			}
		}
	}

}