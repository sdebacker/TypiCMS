<?php
namespace TypiCMS\Modules\Projects\Controllers;

use App;
use View;
use Input;
use Request;
use Session;
use Redirect;
use Response;
use TypiCMS;
use TypiCMS\Modules\Projects\Repositories\ProjectInterface;
use TypiCMS\Modules\Projects\Services\Form\ProjectForm;
use TypiCMS\Controllers\BaseAdminController;

class AdminController extends BaseAdminController
{

    public function __construct(ProjectInterface $project, ProjectForm $projectform)
    {
        parent::__construct($project, $projectform);
        $this->title['parent'] = trans_choice('projects::global.projects', 2);
    }

    /**
     * List models
     * GET /admin/model
     */
    public function index()
    {
        $models = $this->repository->getAll(array('translations'), true);

        $this->layout->content = View::make('projects.admin.index')
            ->withModels($models);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $this->title['child'] = trans('projects::global.New');
        $model = $this->repository->getModel();

        $categories = App::make('TypiCMS\Modules\Categories\Repositories\CategoryInterface')->getAllForSelect();

        $tags = Session::getOldInput('tags');
        $this->layout->content = View::make('projects.admin.create')
            ->withCategories($categories)
            ->withTags($tags)
            ->withModel($model);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return Response
     */
    public function edit($model)
    {
        $this->title['child'] = trans('projects::global.Edit');

        $categories = App::make('TypiCMS\Modules\Categories\Repositories\CategoryInterface')->getAllForSelect();

        $tags = implode(', ', $model->tags->lists('tag'));

        $this->layout->content = View::make('projects.admin.edit')
            ->withCategories($categories)
            ->withTags($tags)
            ->withModel($model);
    }

    /**
     * Show resource.
     *
     * @return Response
     */
    public function show($model)
    {
        return Redirect::route('admin.projects.edit', $model->id);
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
                Redirect::route('admin.projects.index') :
                Redirect::route('admin.projects.edit', $model->id) ;
        }

        return Redirect::route('admin.projects.create')
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
                Redirect::route('admin.projects.index') :
                Redirect::route('admin.projects.edit', $model->id) ;
        }

        return Redirect::route('admin.projects.edit', $model->id)
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
