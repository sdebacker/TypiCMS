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
use TypiCMS\Controllers\BaseAdminController;

class AdminController extends BaseAdminController
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
    public function index($parent = null)
    {
        $models = $this->repository->getAllFromMenu(true, $parent->id);

        $this->layout->content = View::make('menulinks.admin.index')
            ->withModels($models)
            ->withMenu($parent);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create($parent = null)
    {
        $model = $this->repository->getModel();
        $this->title['child'] = trans('menulinks::global.New');

        $selectPages = $this->repository->getPagesForSelect();
        $selectModules = $this->repository->getModulesForSelect();

        $this->layout->content = View::make('menulinks.admin.create')
            ->withMenu($parent)
            ->with('selectPages', $selectPages)
            ->with('selectModules', $selectModules)
            ->withModel($model);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return Response
     */
    public function edit($parent = null, $model)
    {
        $this->title['child'] = trans('menulinks::global.Edit');

        $this->layout->content = View::make('menulinks.admin.edit')
            ->withMenu($parent)
            ->with('selectPages', $this->repository->getPagesForSelect())
            ->with('selectModules', $this->repository->getModulesForSelect())
            ->withModel($model);
    }

    /**
     * Show resource.
     *
     * @return Response
     */
    public function show($parent = null, $model)
    {
        return Redirect::route('admin.menus.menulinks.edit', array($parent->id, $model->id));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store($parent = null)
    {

        if ($model = $this->form->save(Input::all())) {
            return (Input::get('exit')) ?
                Redirect::route('admin.menus.menulinks.index', $parent->id) :
                Redirect::route('admin.menus.menulinks.edit', array($parent->id, $model->id)) ;
        }

        return Redirect::route('admin.menus.menulinks.create', $parent->id)
            ->withInput()
            ->withErrors($this->form->errors());

    }

    /**
     * Update the specified resource in storage.
     *
     * @return Response
     */
    public function update($parent = null, $model)
    {

        if (Request::ajax()) {
            return Response::json($this->repository->update(Input::all()));
        }

        if ($this->form->update(Input::all())) {
            return (Input::get('exit')) ?
                Redirect::route('admin.menus.menulinks.index', $parent->id) :
                Redirect::route('admin.menus.menulinks.edit', array($parent->id, $model->id)) ;
        }

        return Redirect::route('admin.menus.menulinks.edit', array($parent->id, $model->id))
            ->withInput()
            ->withErrors($this->form->errors());

    }
}
