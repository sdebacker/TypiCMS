<?php
namespace TypiCMS\Modules\Files\Controllers;

use View;
use Input;
use Config;
use Request;
use Redirect;
use Response;
use Paginator;
use Notification;
use TypiCMS\Modules\Files\Repositories\FileInterface;
use TypiCMS\Modules\Files\Services\Form\FileForm;
use TypiCMS\Controllers\BaseAdminController;

class AdminController extends BaseAdminController
{

    public function __construct(FileInterface $file, FileForm $fileform)
    {
        parent::__construct($file, $fileform);
        $this->title['parent'] = trans_choice('files::global.files', 2);
    }

    /**
     * List files
     * @return response views
     */
    public function index()
    {
        $allowedViews = ['index', 'filepicker', 'thumbnails', 'gallery'];

        $page       = Input::get('page');
        $type       = Input::get('type');
        $gallery_id = Input::get('gallery_id');
        $view       = Input::get('view', 'thumbnails');
        $view       = ! in_array($view, $allowedViews) ? 'thumbnails' : $view ;

        $itemsPerPage = Config::get('files::admin.itemsPerPage');

        $data = $this->repository->byPageFrom($page, $itemsPerPage, $gallery_id, array('translations'), true, $type);

        $models = Paginator::make($data->items, $data->totalItems, $itemsPerPage);

        $this->layout->content = View::make('files.admin.' . $view)
            ->withModels($models);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $model = $this->repository->getModel();
        $this->title['child'] = trans('files::global.New');
        $this->layout->content = View::make('files.admin.create')
            ->withModel($model);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return Response
     */
    public function edit($model)
    {
        $this->title['child'] = trans('files::global.Edit');
        $this->layout->content = View::make('files.admin.edit')
            ->withModel($model);
    }

    /**
     * Show resource.
     *
     * @return Response
     */
    public function show($model)
    {
        return Redirect::route('admin.files.edit', array($model->id));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {

        if ($model = $this->form->save(Input::all())) {

            if (Request::ajax()) {
                return Response::json(['id' => $model->id]);
            }

            if (Input::get('exit')) {
                return Redirect::route('admin.files.index');
            }
            return Redirect::route('admin.files.edit', array($model->id));

        }

        if (Request::ajax()) {
            return Response::json('error', 400);
        }

        return Redirect::route('admin.files.create')
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
                Redirect::route('admin.files.index') :
                Redirect::route('admin.files.edit', array($model->id)) ;
        }

        return Redirect::route('admin.files.edit', array($model->id))
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
                Notification::success('File '.$model->filename.' deleted.');

                return Redirect::back();
            }
        } else {
            Notification::error('Error deleting file '.$model->filename.'.');
        }
    }
}
