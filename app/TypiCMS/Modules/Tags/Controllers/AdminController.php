<?php
namespace TypiCMS\Modules\Tags\Controllers;

use Config;
use Input;
use Paginator;
use Redirect;
use Request;
use TypiCMS\Controllers\BaseAdminController;
use TypiCMS\Modules\Tags\Repositories\TagInterface;
use TypiCMS\Modules\Tags\Services\Form\TagForm;
use View;

class AdminController extends BaseAdminController
{

    public function __construct(TagInterface $tag, TagForm $tagform)
    {
        parent::__construct($tag, $tagform);
        $this->title['parent'] = trans_choice('tags::global.tags', 2);
    }

    /**
     * List models
     * GET /admin/tags
     */
    public function index()
    {
        if (Request::ajax()) {
            return $this->repository->getAll(array(), true);
        }
        $page = Input::get('page');

        $itemsPerPage = Config::get('tags::admin.itemsPerPage');
        $data = $this->repository->byPage($page, $itemsPerPage, array(), true);
        $models = Paginator::make($data->items, $data->totalItems, $itemsPerPage);

        $this->layout->content = View::make('tags.admin.index')
            ->withModels($models);
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
