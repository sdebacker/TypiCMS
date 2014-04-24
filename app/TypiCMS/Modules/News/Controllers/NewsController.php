<?php
namespace TypiCMS\Modules\News\Controllers;

use Str;
use View;
use Input;
use Config;
use Paginator;

use TypiCMS;

use TypiCMS\Modules\News\Repositories\NewsInterface;

// Presenter
use TypiCMS\Presenters\Presenter;
use TypiCMS\Modules\News\Presenters\NewsPresenter;

// Base controller
use TypiCMS\Controllers\PublicController;

class NewsController extends PublicController
{

    public function __construct(NewsInterface $news, Presenter $presenter)
    {
        parent::__construct($news, $presenter);
        $this->title['parent'] = Str::title(trans_choice('news::global.news', 2));
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $page = Input::get('page');

        $itemsPerPage = Config::get('news::public.itemsPerPage');

        $data = $this->repository->byPage($page, $itemsPerPage, array('translations'));

        $models = Paginator::make($data->items, $data->totalItems, $itemsPerPage);

        $models = $this->presenter->paginator($models, new NewsPresenter);

        $this->layout->content = View::make('news.public.index')->withModels($models);
    }

    /**
     * Show news.
     *
     * @param  int      $id
     * @return Response
     */
    public function show($slug)
    {
        $model = $this->repository->bySlug($slug);

        $model = $this->presenter->model($model, new NewsPresenter);

        TypiCMS::setModel($model);

        $this->title['parent'] = $model->title;

        $this->layout->content = View::make('news.public.show')
            ->withModel($model);
    }
}
