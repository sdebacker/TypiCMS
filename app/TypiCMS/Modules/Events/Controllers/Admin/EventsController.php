<?php namespace TypiCMS\Modules\Events\Controllers\Admin;

use View;
use Input;
use Config;
use Request;
use Redirect;
use Paginator;

use TypiCMS\Modules\Events\Repositories\EventInterface;
use TypiCMS\Modules\Events\Services\Form\EventForm;

// Presenter
use TypiCMS\Presenters\Presenter;
use TypiCMS\Modules\Events\Presenters\EventPresenter;

// Base controller
use TypiCMS\Controllers\BaseController;

class EventsController extends BaseController
{

    public function __construct(EventInterface $event, EventForm $eventform, Presenter $presenter)
    {
        parent::__construct($event, $eventform, $presenter);
        $this->title['parent'] = trans_choice('events::global.events', 2);
    }

    /**
     * List models
     * GET /admin/model
     */
    public function index()
    {
        $page = Input::get('page');

        $itemsPerPage = Config::get('events::admin.itemsPerPage');

        $data = $this->repository->byPage($page, $itemsPerPage, array('translations', 'files'), true);

        $models = Paginator::make($data->items, $data->totalItems, $itemsPerPage);

        $models = $this->presenter->paginator($models, new EventPresenter);

        $this->layout->content = View::make('events.admin.index')->withModels($models);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $this->title['child'] = trans('events::global.New');
        $model = $this->repository->getModel();
        $this->layout->content = View::make('events.admin.create')
            ->with('model', $model);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($model)
    {
        $this->title['child'] = trans('events::global.Edit');
        $this->layout->content = View::make('events.admin.edit')
            ->with('model', $model);
    }


    /**
     * Show resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($model)
    {
        return Redirect::route('admin.events.edit', $model->id);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {

        if ( $model = $this->form->save( Input::all() ) ) {
            return (Input::get('exit')) ? Redirect::route('admin.events.index') : Redirect::route('admin.events.edit', $model->id) ;
        }

        return Redirect::route('admin.events.create')
            ->withInput()
            ->withErrors($this->form->errors());

    }


    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($model)
    {

        Request::ajax() and exit($this->repository->update( Input::all() ));

        if ( $this->form->update( Input::all() ) ) {
            return (Input::get('exit')) ? Redirect::route('admin.events.index') : Redirect::route('admin.events.edit', $model->id) ;
        }
        
        return Redirect::route( 'admin.events.edit', $model->id )
            ->withInput()
            ->withErrors($this->form->errors());

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function sort()
    {
        $sort = $this->repository->sort( Input::all() );
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($model)
    {
        if ( $this->repository->delete($model) ) {
            if ( ! Request::ajax()) {
                return Redirect::back();
            }
        }
    }


}