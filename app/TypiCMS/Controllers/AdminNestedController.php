<?php
namespace TypiCMS\Controllers;

use Input;
use Redirect;
use Request;
use Response;
use View;

abstract class AdminNestedController extends BaseAdminController
{

    /**
     * Set module name
     * @return string
     */
    protected function setModule()
    {
        return Request::segment(4);
    }

    /**
     * Set route base name
     * @return string
     */
    protected function setRoute()
    {
        return Request::segment(2) . '.' . Request::segment(4);
    }

    /**
     * List models
     * GET /admin/model
     */
    public function index($parent = null)
    {
        $this->layout->content = View::make('admin.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create($parent = null)
    {
        $model = $this->repository->getModel();
        $this->layout->content = View::make('admin.create')
            ->withModel($model);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return Response
     */
    public function edit($parent = null, $model)
    {
        $this->layout->content = View::make('admin.edit')
            ->withModel($model);
    }

    /**
     * Show resource.
     *
     * @return Response
     */
    public function show($parent = null, $model)
    {
        return Redirect::route('admin.' . $this->module . '.edit', [$parent->id, $model->id]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store($parent = null)
    {

        if ($model = $this->form->save(Input::all())) {
            return Input::get('exit') ?
                Redirect::route('admin.' . $this->route . '.index', $parent->id) :
                Redirect::route('admin.' . $this->route . '.edit', [$parent->id, $model->id]) ;
        }

        return Redirect::route('admin.' . $this->route . '.create')
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
            return Input::get('exit') ?
                Redirect::route('admin.' . $this->route . '.index', $parent->id) :
                Redirect::route('admin.' . $this->route . '.edit', [$parent->id, $model->id]) ;
        }

        return Redirect::route('admin.' . $this->route . '.edit', [$parent->id, $model->id])
            ->withInput()
            ->withErrors($this->form->errors());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return Response
     */
    public function destroy($parent = null, $model)
    {
        if ($this->repository->delete($model)) {
            if (! Request::ajax()) {
                return Redirect::back();
            }
        }
    }
}
