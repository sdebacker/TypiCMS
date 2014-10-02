<?php
namespace TypiCMS\Modules\Menulinks\Controllers;

use Response;
use TypiCMS\Controllers\BaseApiController;
use TypiCMS\Modules\Menulinks\Repositories\MenulinkInterface as Repository;

class ApiController extends BaseApiController
{
    public function __construct(Repository $repository)
    {
        parent::__construct($repository);
    }

    /**
     * Get models
     * @return Response
     */
    public function index()
    {
        $models = $this->repository->getAllBy('menu_id', 1, [], true);
        return Response::json($models, 200);
    }
}
