<?php
namespace TypiCMS\Modules\Pages\Controllers\Admin;

use View;
use Input;
use TypiCMS;
use Request;
use Redirect;

use TypiCMS\Modules\Pages\Repositories\PageInterface;
use TypiCMS\Modules\Pages\Services\Form\PageForm;

// Presenter
use TypiCMS\Presenters\Presenter;
use TypiCMS\Modules\Pages\Presenters\PagePresenter;

// Base controller
use TypiCMS\Controllers\BaseController;

class PagesController extends BaseController
{

    public function __construct(PageInterface $page, PageForm $pageform, Presenter $presenter)
    {
        parent::__construct($page, $pageform, $presenter);
        $this->title['parent'] = trans_choice('pages::global.pages', 2);
    }

    /**
     * List models
     * GET /admin/model
     */
    public function index()
    {
        $models = $this->repository->getAll(array('translations', 'files'), true);

        $models = $this->presenter->collection($models, new PagePresenter);

        $this->layout->content = View::make('pages.admin.index')
            ->withModels($models);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $this->title['child'] = trans('pages::global.New');
        $model = $this->repository->getModel();
        $model = $this->presenter->model($model, new PagePresenter);
        $this->layout->content = View::make('pages.admin.create')
            ->with('model', $model);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int      $id
     * @return Response
     */
    public function edit($model)
    {
        $this->title['child'] = trans('pages::global.Edit');
        $model = $this->presenter->model($model, new PagePresenter);
        TypiCMS::setModel($model);
        $this->layout->content = View::make('pages.admin.edit')
            ->withModel($model);
    }

    /**
     * Show resource.
     *
     * @param  int      $id
     * @return Response
     */
    public function show($model)
    {
        return Redirect::route('admin.pages.edit', $model->id);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {

        if ( $model = $this->form->save( Input::all() ) ) {
            return (Input::get('exit')) ? Redirect::route('admin.pages.index') : Redirect::route('admin.pages.edit', $model->id) ;
        }

        return Redirect::route('admin.pages.create')
            ->withInput()
            ->withErrors($this->form->errors());

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int      $id
     * @return Response
     */
    public function update($model)
    {
        Request::ajax() and exit($this->repository->update( Input::all() ));

        if ( $this->form->update( Input::all() ) ) {
            return (Input::get('exit')) ? Redirect::route('admin.pages.index') : Redirect::route('admin.pages.edit', $model->id) ;
        }

        return Redirect::route( 'admin.pages.edit', $model->id )
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
    public function destroy($model)
    {
        if ( $this->repository->delete($model) ) {
            if ( ! Request::ajax()) {
                return Redirect::back();
            }
        }
    }

}
