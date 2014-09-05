<?php
namespace TypiCMS\Modules\Contacts\Controllers;

use View;
use Input;
use Config;
use Request;
use Redirect;
use Response;
use Paginator;
use TypiCMS;
use TypiCMS\Modules\Contacts\Repositories\ContactInterface;
use TypiCMS\Modules\Contacts\Services\Form\ContactForm;
use TypiCMS\Controllers\BaseAdminController;

class AdminController extends BaseAdminController
{

    public function __construct(ContactInterface $contact, ContactForm $contactform)
    {
        parent::__construct($contact, $contactform);
        $this->title['parent'] = trans_choice('contacts::global.contacts', 2);
    }

    /**
     * List models
     * GET /admin/model
     */
    public function index()
    {
        $page = Input::get('page');

        $itemsPerPage = Config::get('contacts::admin.itemsPerPage');

        $data = $this->repository->byPage($page, $itemsPerPage, array(), true);

        $models = Paginator::make($data->items, $data->totalItems, $itemsPerPage);

        $this->layout->content = View::make('contacts.admin.index')->withModels($models);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $this->title['child'] = trans('contacts::global.New');
        $model = $this->repository->getModel();
        $this->layout->content = View::make('contacts.admin.create')
            ->with('model', $model);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return Response
     */
    public function edit($model)
    {
        $this->title['child'] = trans('contacts::global.Edit');
        $this->layout->content = View::make('contacts.admin.edit')
            ->with('model', $model);
    }

    /**
     * Show resource.
     *
     * @return Response
     */
    public function show($model)
    {
        return Redirect::route('admin.contacts.edit', $model->id);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {

        if ($model = $this->form->save(Input::all())) {
            return (Input::get('exit')) ?
                Redirect::route('admin.contacts.index') :
                Redirect::route('admin.contacts.edit', $model->id) ;
        }

        return Redirect::route('admin.contacts.create')
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
            return (Input::get('exit')) ?
                Redirect::route('admin.contacts.index') :
                Redirect::route('admin.contacts.edit', $model->id) ;
        }

        return Redirect::route('admin.contacts.edit', $model->id)
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
