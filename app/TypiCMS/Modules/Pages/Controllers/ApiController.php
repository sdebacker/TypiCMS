<?php
namespace TypiCMS\Modules\Pages\Controllers;

use Response;
use TypiCMS\Controllers\BaseApiController;
use TypiCMS\Modules\Pages\Repositories\PageInterface as Repository;

class ApiController extends BaseApiController
{
    public function __construct(Repository $repository)
    {
        parent::__construct($repository);
    }

    /**
     * List models
     * GET /admin/model
     */
    public function index()
    {
        $models = $this->repository->getAllNested([], true);
        return Response::json($models, 200);
    }
}
