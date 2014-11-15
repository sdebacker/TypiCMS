<?php
namespace TypiCMS\Modules\Menulinks\Controllers;

use Lang;
use View;
use Illuminate\Database\Eloquent\Model;
use Input;
use Redirect;
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
     * Redirect to menu edit form
     * 
     * @param  Model $parent
     * @return Redirect
     */
    public function index(Model $parent = null)
    {
        return Redirect::route('admin.menus.edit', $parent->id);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  Model $parent
     * @return void
     */
    public function create(Model $parent = null)
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
     * @param  Model $parent
     * @param  Model $model
     * @return void
     */
    public function edit(Model $parent = null, Model $model)
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
     * @param  Model $parent
     * @param  Model $model
     * @return Redirect
     */
    public function show(Model $parent = null, Model $model)
    {
        return Redirect::route('admin.menus.menulinks.edit', [$parent->id, $model->id]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Model $parent
     * @return Redirect
     */
    public function store(Model $parent = null)
    {
        if ($model = $this->form->save(Input::all())) {
            $redirectUrl = Input::get('exit') ? $parent->editUrl() : $model->editUrl() ;
            return Redirect::to($redirectUrl);
        }

        return Redirect::route('admin.menus.menulinks.create', $parent->id)
            ->withInput()
            ->withErrors($this->form->errors());

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Model $parent
     * @param  Model $model
     * @return Redirect
     */
    public function update(Model $parent = null, Model $model)
    {

        if ($this->form->update(Input::all())) {
            $redirectUrl = Input::get('exit') ? $parent->editUrl() : $model->editUrl() ;
            return Redirect::to($redirectUrl);
        }

        return Redirect::to($model->editUrl())
            ->withInput()
            ->withErrors($this->form->errors());

    }
}
