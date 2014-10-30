<?php
namespace TypiCMS\Modules\Menulinks\Controllers;

use Input;
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
        $id = Input::get('menu_id');
        $models = $this->repository->getAllByNested('menu_id', $id, [], true);
        return Response::json($models, 200);
    }
}
