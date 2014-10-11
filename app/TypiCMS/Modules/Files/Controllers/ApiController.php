<?php
namespace TypiCMS\Modules\Files\Controllers;

use Input;
use TypiCMS\Controllers\BaseApiController;
use TypiCMS\Modules\Files\Repositories\FileInterface as Repository;
use Response;

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
        if ($gallery_id = Input::get('gallery_id', 0)) {
            $models = $this->repository->getAllBy('gallery_id', $gallery_id, [], true);
        } else {
            $models = $this->repository->getAll([], true);
        }
        return Response::json($models, 200);
    }
}
