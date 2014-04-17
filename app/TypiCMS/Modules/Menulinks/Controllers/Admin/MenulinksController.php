<?php
namespace TypiCMS\Modules\Menulinks\Controllers\Admin;

use Lang;
use View;
use Input;
use Request;
use Redirect;

use TypiCMS\Modules\Menulinks\Repositories\MenulinkInterface;
use TypiCMS\Modules\Menulinks\Services\Form\MenulinkForm;

// Presenter
use TypiCMS\Presenters\Presenter;
use TypiCMS\Modules\Menulinks\Presenters\MenulinkPresenter;

// Base controller
use TypiCMS\Controllers\BaseController;

class MenulinksController extends BaseController
{

    public function __construct(MenulinkInterface $menulink, MenulinkForm $menulinkform, Presenter $presenter)
    {
        parent::__construct($menulink, $menulinkform, $presenter);
        $this->title['parent'] = Lang::choice('menulinks::global.menulinks', 2);
        // $this->model = $menulink;
    }

    /**
     * List models
     * GET /admin/model
     */
    public function index($menu)
    {
        $models = $this->repository->getAllFromMenu(true, $menu->id);

        $models = $this->presenter->collection($models, new MenulinkPresenter);

        $this->layout->content = View::make('menulinks.admin.index')
            ->withModels($models)
            ->withMenu($menu);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create($menu)
    {
        $model = $this->repository->getModel();
        $this->title['child'] = trans('menulinks::global.New');

        $selectPages = $this->repository->getPagesForSelect();
        $selectModules = $this->repository->getModulesForSelect();

        $this->layout->content = View::make('menulinks.admin.create')
            ->withMenu($menu)
            ->with('selectPages', $selectPages)
            ->with('selectModules', $selectModules)
            ->withModel($model);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int      $id
     * @return Response
     */
    public function edit($menu, $model)
    {
        $model = $this->presenter->model($model, new MenulinkPresenter);
        $this->title['child'] = trans('menulinks::global.Edit');

        $this->layout->content = View::make('menulinks.admin.edit')
            ->withMenu($menu)
            ->with('selectPages', $this->repository->getPagesForSelect())
            ->with('selectModules', $this->repository->getModulesForSelect())
            ->withModel($model);
    }

    /**
     * Show resource.
     *
     * @param  int      $id
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

        if ( $model = $this->form->save( Input::all() ) ) {
            return (Input::get('exit')) ? Redirect::route('admin.menus.menulinks.index', $menu->id) : Redirect::route('admin.menus.menulinks.edit', array($menu->id, $model->id)) ;
        }

        return Redirect::route('admin.menus.menulinks.create', $menu->id)
            ->withInput()
            ->withErrors($this->form->errors());

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int      $id
     * @return Response
     */
    public function update($menu, $model)
    {

        Request::ajax() and exit($this->repository->update( Input::all() ));

        if ( $this->form->update( Input::all() ) ) {
            return (Input::get('exit')) ? Redirect::route('admin.menus.menulinks.index', $menu->id) : Redirect::route('admin.menus.menulinks.edit', array($menu->id, $model->id)) ;
        }

        return Redirect::route( 'admin.menus.menulinks.edit', array($menu->id, $model->id) )
            ->withInput()
            ->withErrors($this->form->errors());

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int      $id
     * @return Response
     */
    public function sort()
    {
        $this->repository->sort( Input::all() );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int      $id
     * @return Response
     */
    public function destroy($menu, $model)
    {
        if ( $this->repository->delete($model) ) {
            if ( ! Request::ajax()) {
                return Redirect::back();
            }
        }
    }

}
