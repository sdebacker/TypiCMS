<?php
namespace TypiCMS\Modules\Events\Controllers;

use Str;
use View;
use Input;
use Config;
use Paginator;

use TypiCMS;

use TypiCMS\Modules\Events\Repositories\EventInterface;

// Presenter
use TypiCMS\Presenters\Presenter;
use TypiCMS\Modules\Events\Presenters\EventPresenter;

// Base controller
use TypiCMS\Controllers\PublicController;

class EventsController extends PublicController
{

    public function __construct(EventInterface $event, Presenter $presenter)
    {
        parent::__construct($event, $presenter);
        $this->title['parent'] = Str::title(trans_choice('events::global.events', 2));
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $page = Input::get('page');

        $itemsPerPage = Config::get('events::public.itemsPerPage');

        $data = $this->repository->byPage($page, $itemsPerPage, array('translations'));

        $models = Paginator::make($data->items, $data->totalItems, $itemsPerPage);

        $models = $this->presenter->paginator($models, new EventPresenter);

        $this->layout->content = View::make('events.public.index')->withModels($models);
    }

    /**
     * Show event.
     *
     * @param  int      $id
     * @return Response
     */
    public function show($slug)
    {
        $model = $this->repository->bySlug($slug);

        $model = $this->presenter->model($model, new EventPresenter);

        TypiCMS::setModel($model);

        $this->title['parent'] = $model->title;

        $this->layout->content = View::make('events.public.show')
            ->withModel($model);
    }

}
