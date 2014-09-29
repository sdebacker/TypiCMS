<?php
namespace TypiCMS\Modules\Projects\Controllers;

use Response;
use Session;
use TypiCMS\Controllers\AdminSimpleController;
use TypiCMS\Modules\Projects\Repositories\ProjectInterface;
use TypiCMS\Modules\Projects\Services\Form\ProjectForm;
use View;

class AdminController extends AdminSimpleController
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
        $model = $this->repository->getModel();
        $tags = Session::getOldInput('tags');
        $this->layout->content = View::make('admin.create')
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
        $tags = implode(', ', $model->tags->lists('tag'));
        $this->layout->content = View::make('admin.edit')
            ->withTags($tags)
            ->withModel($model);
    }
}
