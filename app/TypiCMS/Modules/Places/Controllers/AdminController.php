<?php
namespace TypiCMS\Modules\Places\Controllers;

use View;
use Input;
use Config;
use Request;
use TypiCMS;
use Redirect;
use Response;
use Paginator;
use TypiCMS\Modules\Places\Repositories\PlaceInterface;
use TypiCMS\Modules\Places\Services\Form\PlaceForm;
use TypiCMS\Controllers\BaseAdminController;

class AdminController extends BaseAdminController
{

    public function __construct(PlaceInterface $place, PlaceForm $placeform)
    {
        parent::__construct($place, $placeform);
        $this->title['parent'] = trans_choice('places::global.places', 2);
    }

    /**
     * List models
     * GET /admin/model
     */
    public function index()
    {

        $page = Input::get('page');

        $itemsPerPage = Config::get('places::admin.itemsPerPage');

        $data = $this->repository->byPage($page, $itemsPerPage, array('translations'), true);

        $models = Paginator::make($data->items, $data->totalItems, $itemsPerPage);

        $this->layout->content = View::make('places.admin.index')
            ->withModels($models);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $this->title['child'] = trans('places::global.New');
        $model = $this->repository->getModel();
        $this->layout->content = View::make('places.admin.create')
            ->withModel($model);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return Response
     */
    public function edit($model)
    {
        $this->title['child'] = trans('places::global.Edit');
        $this->layout->content = View::make('places.admin.edit')
            ->withModel($model);
    }

    /**
     * Show resource.
     *
     * @return Response
     */
    public function show($model)
    {
        return Redirect::route('admin.places.edit', $model->id);
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
                Redirect::route('admin.places.index') :
                Redirect::route('admin.places.edit', $model->id) ;
        }

        return Redirect::route('admin.places.create')
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
                Redirect::route('admin.places.index') :
                Redirect::route('admin.places.edit', $model->id) ;
        }

        return Redirect::route('admin.places.edit', $model->id)
            ->withInput()
            ->withErrors($this->form->errors());
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
