<?php
namespace TypiCMS\Modules\News\Controllers;

use Str;
use View;
use Input;
use Config;
use Paginator;
use TypiCMS;
use TypiCMS\Modules\News\Repositories\NewsInterface;
use TypiCMS\Controllers\BasePublicController;

class PublicController extends BasePublicController
{

    public function __construct(NewsInterface $news)
    {
        parent::__construct($news);
        $this->title['parent'] = Str::title(trans_choice('news::global.news', 2));
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        TypiCMS::setModel($this->repository->getModel());

        $page = Input::get('page');
        $itemsPerPage = Config::get('news::public.itemsPerPage');

        $data = $this->repository->byPage($page, $itemsPerPage, array('translations'));

        $models = Paginator::make($data->items, $data->totalItems, $itemsPerPage);

        $this->layout->content = View::make('news.public.index')->withModels($models);
    }

    /**
     * Show news.
     *
     * @return Response
     */
    public function show($slug)
    {
        $model = $this->repository->bySlug($slug);

        TypiCMS::setModel($model);

        $this->title['parent'] = $model->title;

        $this->layout->content = View::make('news.public.show')
            ->withModel($model);
    }
}
