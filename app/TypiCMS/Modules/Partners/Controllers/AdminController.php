<?php
namespace TypiCMS\Modules\Partners\Controllers;

use View;
use Input;
use Config;
use Request;
use TypiCMS;
use Redirect;
use Response;
use Paginator;
use TypiCMS\Modules\Partners\Repositories\PartnerInterface;
use TypiCMS\Modules\Partners\Services\Form\PartnerForm;
use TypiCMS\Controllers\BaseAdminController;

class AdminController extends BaseAdminController
{

    public function __construct(PartnerInterface $partner, PartnerForm $partnerform)
    {
        parent::__construct($partner, $partnerform);
        $this->title['parent'] = trans_choice('partners::global.partners', 2);
    }

    /**
     * List models
     * GET /admin/model
     */
    public function index()
    {

        $page = Input::get('page');

        $itemsPerPage = Config::get('partners::admin.itemsPerPage');

        $data = $this->repository->byPage($page, $itemsPerPage, array(), true);

        $models = Paginator::make($data->items, $data->totalItems, $itemsPerPage);

        $this->layout->content = View::make('partners.admin.index')
            ->withModels($models);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $this->title['child'] = trans('partners::global.New');
        $model = $this->repository->getModel();
        $this->layout->content = View::make('partners.admin.create')
            ->withModel($model);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return Response
     */
    public function edit($model)
    {
        $this->title['child'] = trans('partners::global.Edit');
        $this->layout->content = View::make('partners.admin.edit')
            ->withModel($model);
    }

    /**
     * Show resource.
     *
     * @return Response
     */
    public function show($model)
    {
        return Redirect::route('admin.partners.edit', $model->id);
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
                Redirect::route('admin.partners.index') :
                Redirect::route('admin.partners.edit', $model->id) ;
        }

        return Redirect::route('admin.partners.create')
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
                Redirect::route('admin.partners.index') :
                Redirect::route('admin.partners.edit', $model->id) ;
        }

        return Redirect::route('admin.partners.edit', $model->id)
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
