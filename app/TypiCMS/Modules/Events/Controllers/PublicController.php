<?php
namespace TypiCMS\Modules\Events\Controllers;

use Str;
use View;
use Input;
use Config;
use Paginator;

use TypiCMS;

use TypiCMS\Modules\Events\Repositories\EventInterface;

// Base controller
use TypiCMS\Controllers\BasePublicController;

class PublicController extends BasePublicController
{

    public function __construct(EventInterface $event)
    {
        parent::__construct($event);
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

        TypiCMS::setModel($model);

        $this->title['parent'] = $model->title;

        $this->layout->content = View::make('events.public.show')
            ->withModel($model);
    }
}
