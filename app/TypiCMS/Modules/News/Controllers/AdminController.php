<?php
namespace TypiCMS\Modules\News\Controllers;

use Str;
use View;
use Input;
use Config;
use Request;
use Redirect;
use Response;
use Paginator;
use TypiCMS;
use TypiCMS\Modules\News\Repositories\NewsInterface;
use TypiCMS\Modules\News\Services\Form\NewsForm;
use TypiCMS\Controllers\BaseAdminController;

class AdminController extends BaseAdminController
{

    public function __construct(NewsInterface $news, NewsForm $newsform)
    {
        parent::__construct($news, $newsform);
        $this->title['parent'] = Str::title(trans_choice('news::global.news', 2));
    }

    /**
     * List models
     * GET /admin/model
     */
    public function index()
    {
        $page = Input::get('page');

        $itemsPerPage = Config::get('news::admin.itemsPerPage');

        $data = $this->repository->byPage($page, $itemsPerPage, array('translations'), true);

        $models = Paginator::make($data->items, $data->totalItems, $itemsPerPage);

        $this->layout->content = View::make('news.admin.index')->withModels($models);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $this->title['child'] = trans('news::global.New');
        $model = $this->repository->getModel();
        $this->layout->content = View::make('news.admin.create')
            ->withModel($model);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return Response
     */
    public function edit($model)
    {
        $this->title['child'] = trans('news::global.Edit');
        $this->layout->content = View::make('news.admin.edit')
            ->withModel($model);
    }

    /**
     * Show resource.
     *
     * @return Response
     */
    public function show($model)
    {
        return Redirect::route('admin.news.edit', $model->id);
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
                Redirect::route('admin.news.index') :
                Redirect::route('admin.news.edit', $model->id) ;
        }

        return Redirect::route('admin.news.create')
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
                Redirect::route('admin.news.index') :
                Redirect::route('admin.news.edit', $model->id) ;
        }

        return Redirect::route('admin.news.edit', $model->id)
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
