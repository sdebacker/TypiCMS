<?php
namespace TypiCMS\Modules\Projects\Controllers;

use App;
use Response;
use Session;
use TypiCMS\Controllers\BaseAdminController;
use TypiCMS\Modules\Projects\Repositories\ProjectInterface;
use TypiCMS\Modules\Projects\Services\Form\ProjectForm;
use View;

class AdminController extends BaseAdminController
{

    public function __construct(ProjectInterface $project, ProjectForm $projectform)
    {
        parent::__construct($project, $projectform);
        $this->title['parent'] = trans_choice('projects::global.projects', 2);
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
}
