<?php namespace TypiCMS\Modules\Projects\Controllers\Admin;

use App;
use View;
use Input;
use Config;
use Request;
use Session;
use Redirect;

use TypiCMS\Modules\Projects\Repositories\ProjectInterface;
use TypiCMS\Modules\Projects\Services\Form\ProjectForm;

// Presenter
use TypiCMS\Presenters\Presenter;
use TypiCMS\Modules\Projects\Presenters\ProjectPresenter;

// Base controller
use TypiCMS\Controllers\BaseController;

class ProjectsController extends BaseController {

    public function __construct(ProjectInterface $project, ProjectForm $projectform, Presenter $presenter)
    {
        parent::__construct($project, $projectform, $presenter);
        $this->title['parent'] = trans_choice('projects::global.projects', 2);
    }

    /**
     * List models
     * GET /admin/model
     */
    public function index()
    {
        $models = $this->repository->getAll(true);

        $models = $this->presenter->collection($models, new ProjectPresenter);

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
        $model = $this->repository->getModel();

        $categories = App::make('TypiCMS\Modules\Categories\Repositories\CategoryInterface')->getAllForSelect();

        $tags = Session::getOldInput('tags');

        $this->title['child'] = trans('projects::global.New');
        $this->layout->content = View::make('projects.admin.create')
            ->withCategories($categories)
            ->withTags($tags)
            ->withModel($model);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($model)
    {

        $this->title['child'] = trans('projects::global.Edit');

        $categories = App::make('TypiCMS\Modules\Categories\Repositories\CategoryInterface')->getAllForSelect();

        $tags = '';
        $model->tags->each(function($tag) use(&$tags)
        {
            $tags .= $tag->tag.', ';
        });
        $tags = substr($tags, 0, -2);

        $this->layout->content = View::make('projects.admin.edit')
            ->withCategories($categories)
            ->withTags($tags)
            ->withModel($model);
    }


    /**
     * Show resource.
     *
     * @param  int  $id
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

        if ( $model = $this->form->save( Input::all() ) ) {
            return (Input::get('exit')) ? Redirect::route('admin.projects.index') : Redirect::route('admin.projects.edit', $model->id) ;
        }

        return Redirect::route('admin.projects.create')
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
            return (Input::get('exit')) ? Redirect::route('admin.projects.index') : Redirect::route('admin.projects.edit', $model->id) ;
        }
        
        return Redirect::route( 'admin.projects.edit', $model->id )
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