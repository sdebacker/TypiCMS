<?php
namespace TypiCMS\Modules\Tags\Controllers;

use Config;
use Input;
use Paginator;
use Request;
use TypiCMS\Controllers\AdminSimpleController;
use TypiCMS\Modules\Tags\Repositories\TagInterface;
use TypiCMS\Modules\Tags\Services\Form\TagForm;
use View;

class AdminController extends AdminSimpleController
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

        $this->layout->content = View::make('admin.index')
            ->withModels($models);
    }
}
