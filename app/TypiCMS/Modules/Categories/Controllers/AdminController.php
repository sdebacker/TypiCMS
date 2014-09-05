<?php
namespace TypiCMS\Modules\Categories\Controllers;

use View;
use Input;
use Request;
use Redirect;
use Response;
use TypiCMS\Modules\Categories\Repositories\CategoryInterface;
use TypiCMS\Modules\Categories\Services\Form\CategoryForm;
use TypiCMS\Controllers\BaseAdminController;

class AdminController extends BaseAdminController
{

    public function __construct(CategoryInterface $category, CategoryForm $categoryform)
    {
        parent::__construct($category, $categoryform);
        $this->title['parent'] = trans_choice('categories::global.categories', 2);
    }

    /**
     * List models
     * GET /admin/model
     */
    public function index()
    {
        $models = $this->repository->getAll(array('translations', 'projects'), true);

        $this->layout->content = View::make('categories.admin.index')->withModels($models);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $this->title['child'] = trans('categories::global.New');
        $model = $this->repository->getModel();
        $this->layout->content = View::make('categories.admin.create')
            ->with('model', $model);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return Response
     */
    public function edit($model)
    {
        $this->title['child'] = trans('categories::global.Edit');
        $this->layout->content = View::make('categories.admin.edit')
            ->with('model', $model);
    }

    /**
     * Show resource.
     *
     * @return Response
     */
    public function show($model)
    {
        return Redirect::route('admin.categories.edit', $model->id);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {

        if ($model = $this->form->save(Input::all())) {
            return Input::get('exit') ?
                Redirect::route('admin.categories.index') :
                Redirect::route('admin.categories.edit', $model->id) ;
        }

        return Redirect::route('admin.categories.create')
            ->withInput()
            ->withErrors($this->form->errors());

    }

    /**
     * Update the specified resource in storage.
     *
     * @return Response
     */
    public function update($model)
    {

        if (Request::ajax()) {
            return Response::json($this->repository->update(Input::all()));
        }

        if ($this->form->update(Input::all())) {
            return Input::get('exit') ?
                Redirect::route('admin.categories.index') :
                Redirect::route('admin.categories.edit', $model->id) ;
        }

        return Redirect::route('admin.categories.edit', $model->id)
            ->withInput()
            ->withErrors($this->form->errors());
    }

    /**
     * Update the specified resource in storage.
     *
     * @return Response
     */
    public function sort()
    {
        $this->repository->sort(Input::all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return Response
     */
    public function destroy($model)
    {
        if ($this->repository->delete($model)) {
            if (! Request::ajax()) {
                return Redirect::back();
            }
        }
    }
}
