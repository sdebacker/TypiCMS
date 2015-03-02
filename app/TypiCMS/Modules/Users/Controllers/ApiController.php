<?php
namespace TypiCMS\Modules\Users\Controllers;

use Illuminate\Database\Eloquent\Model;
use Response;
use Sentry;
use TypiCMS\Controllers\BaseApiController;
use TypiCMS\Modules\Users\Repositories\UserInterface as Repository;

class ApiController extends BaseApiController
{
    public function __construct(Repository $repository)
    {
        parent::__construct($repository);
    }

    /**
     * Remove the specified resource from storage.
     * 
     * @param  Model    $model
     * @return Response
     */
    public function destroy(Model $model)
    {
        if ($model->id == Sentry::getUser()->id) {
            return Response::json([
                'error'   => true,
                'message' => 'Connected user can not be deleted.'
            ], 403);
        }
        return parent::destroy($model);
    }
}
