<?php
namespace TypiCMS\Modules\Translations\Controllers;

use Response;
use TypiCMS\Controllers\BaseApiController;
use TypiCMS\Modules\Translations\Repositories\TranslationInterface as Repository;

class ApiController extends BaseApiController
{
    public function __construct(Repository $repository)
    {
        parent::__construct($repository);
    }

    /**
     * Get models
     * 
     * @return Response
     */
    public function index()
    {
        $models = $this->repository->getAll([], true);
        return Response::json($models, 200);
    }
}
