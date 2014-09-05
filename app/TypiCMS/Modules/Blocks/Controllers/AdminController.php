<?php
namespace TypiCMS\Modules\Blocks\Controllers;

use View;
use Input;
use Config;
use Request;
use TypiCMS;
use Redirect;
use Response;
use Paginator;
use TypiCMS\Modules\Blocks\Repositories\BlockInterface;
use TypiCMS\Modules\Blocks\Services\Form\BlockForm;
use TypiCMS\Controllers\BaseAdminController;

class AdminController extends BaseAdminController
{

    public function __construct(BlockInterface $block, BlockForm $blockform)
    {
        parent::__construct($block, $blockform);
        $this->title['parent'] = trans_choice('blocks::global.blocks', 2);
    }

    /**
     * List models
     * GET /admin/model
     */
    public function index()
    {

        $page = Input::get('page');

        $itemsPerPage = Config::get('blocks::admin.itemsPerPage');

        $data = $this->repository->byPage($page, $itemsPerPage, array(), true);

        $models = Paginator::make($data->items, $data->totalItems, $itemsPerPage);

        $this->layout->content = View::make('blocks.admin.index')
            ->withModels($models);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $this->title['child'] = trans('blocks::global.New');
        $model = $this->repository->getModel();
        $this->layout->content = View::make('blocks.admin.create')
            ->withModel($model);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return Response
     */
    public function edit($model)
    {
        $this->title['child'] = trans('blocks::global.Edit');
        $this->layout->content = View::make('blocks.admin.edit')
            ->withModel($model);
    }

    /**
     * Show resource.
     *
     * @return Response
     */
    public function show($model)
    {
        return Redirect::route('admin.blocks.edit', $model->id);
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
                Redirect::route('admin.blocks.index') :
                Redirect::route('admin.blocks.edit', $model->id) ;
        }

        return Redirect::route('admin.blocks.create')
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
                Redirect::route('admin.blocks.index') :
                Redirect::route('admin.blocks.edit', $model->id) ;
        }

        return Redirect::route('admin.blocks.edit', $model->id)
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
