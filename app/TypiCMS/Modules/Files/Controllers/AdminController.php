<?php
namespace TypiCMS\Modules\Files\Controllers;

use Config;
use Input;
use Paginator;
use Redirect;
use Request;
use Response;
use TypiCMS\Controllers\AdminSimpleController;
use TypiCMS\Modules\Files\Repositories\FileInterface;
use TypiCMS\Modules\Files\Services\Form\FileForm;
use View;

class AdminController extends AdminSimpleController
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
}
