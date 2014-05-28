<?php
namespace TypiCMS\Modules\Galleries\Controllers;

use View;
use Input;
use Config;
use Request;
use Redirect;
use Response;
use Paginator;

use TypiCMS;

use TypiCMS\Modules\Galleries\Repositories\GalleryInterface;
use TypiCMS\Modules\Galleries\Services\Form\GalleryForm;

// Base controller
use TypiCMS\Controllers\BaseAdminController;

class AdminController extends BaseAdminController
{

    public function __construct(GalleryInterface $gallery, GalleryForm $galleryform)
    {
        parent::__construct($gallery, $galleryform);
        $this->title['parent'] = trans_choice('galleries::global.galleries', 2);
    }

    /**
     * List models
     * GET /admin/model
     */
    public function index()
    {
        if (Request::ajax()) {
            $galleries = $this->repository->getSlugs();
            return Response::json($galleries);
        }

        $page = Input::get('page');

        $itemsPerPage = Config::get('galleries::admin.itemsPerPage');

        $data = $this->repository->byPage($page, $itemsPerPage, array('translations', 'files'), true);

        $models = Paginator::make($data->items, $data->totalItems, $itemsPerPage);

        $this->layout->content = View::make('galleries.admin.index')->withModels($models);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $this->title['child'] = trans('galleries::global.New');
        $model = $this->repository->getModel();
        $this->layout->content = View::make('galleries.admin.create')
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
        TypiCMS::setModel($model);
        $this->title['child'] = trans('galleries::global.Edit');
        $this->layout->content = View::make('galleries.admin.edit')
            ->with('model', $model);
    }

    /**
     * Show resource.
     *
     * @param  int      $id
     * @return Response
     */
    public function show($model)
    {
        return Redirect::route('admin.galleries.edit', $model->id);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {

        if ($model = $this->form->save(Input::all())) {
            return (Input::get('exit')) ? Redirect::route('admin.galleries.index') : Redirect::route('admin.galleries.edit', $model->id) ;
        }

        return Redirect::route('admin.galleries.create')
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

        Request::ajax() and exit($this->repository->update(Input::all()));

        if ($this->form->update(Input::all())) {
            return (Input::get('exit')) ? Redirect::route('admin.galleries.index') : Redirect::route('admin.galleries.edit', $model->id) ;
        }

        return Redirect::route('admin.galleries.edit', $model->id)
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
        $this->repository->sort(Input::all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int      $id
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
