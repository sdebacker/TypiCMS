<?php
namespace TypiCMS\Modules\Menulinks\Controllers;

use Lang;
use View;
use Input;
use Request;
use Redirect;
use Response;
use TypiCMS\Modules\Menulinks\Repositories\MenulinkInterface;
use TypiCMS\Modules\Menulinks\Services\Form\MenulinkForm;
use TypiCMS\Controllers\AdminNestedController;

class AdminController extends AdminNestedController
{

    public function __construct(MenulinkInterface $menulink, MenulinkForm $menulinkform)
    {
        parent::__construct($menulink, $menulinkform);
        $this->title['parent'] = Lang::choice('menulinks::global.menulinks', 2);
    }

    /**
     * List models
     * GET /admin/model
     */
    public function index($menu = null)
    {
        return Redirect::route('admin.menus.edit', $menu->id);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create($menu = null)
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
     * @return Response
     */
    public function edit($menu = null, $model)
    {
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
     * @return Response
     */
    public function show($menu = null, $model)
    {
        return Redirect::route('admin.menus.menulinks.edit', [$menu->id, $model->id]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store($menu = null)
    {

        if ($model = $this->form->save(Input::all())) {
            return (Input::get('exit')) ?
                Redirect::route('admin.menus.edit', $menu->id) :
                Redirect::route('admin.menus.menulinks.edit', [$menu->id, $model->id]) ;
        }

        return Redirect::route('admin.menus.menulinks.create', $menu->id)
            ->withInput()
            ->withErrors($this->form->errors());

    }

    /**
     * Update the specified resource in storage.
     *
     * @return Response
     */
    public function update($menu = null, $model)
    {

        if (Request::ajax()) {
            return Response::json($this->repository->update(Input::all()));
        }

        if ($this->form->update(Input::all())) {
            return (Input::get('exit')) ?
                Redirect::route('admin.menus.edit', $menu->id) :
                Redirect::route('admin.menus.menulinks.edit', [$menu->id, $model->id]) ;
        }

        return Redirect::route('admin.menus.menulinks.edit', [$menu->id, $model->id])
            ->withInput()
            ->withErrors($this->form->errors());

    }
}
