<?php
namespace TypiCMS\Modules\Events\Controllers;

use Str;
use View;
use Input;
use Config;
use Response;
use Paginator;
use TypiCMS;
use TypiCMS\Modules\Events\Services\Calendar;
use TypiCMS\Modules\Events\Repositories\EventInterface;
use TypiCMS\Controllers\BasePublicController;

class PublicController extends BasePublicController
{

    protected $calendar;

    public function __construct(EventInterface $event, Calendar $calendar)
    {
        parent::__construct($event);
        $this->title['parent'] = Str::title(trans_choice('events::global.events', 2));
        $this->calendar = $calendar;
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
        $itemsPerPage = Config::get('events::public.itemsPerPage');

        $data = $this->repository->byPage($page, $itemsPerPage, array('translations'));

        $models = Paginator::make($data->items, $data->totalItems, $itemsPerPage);

        $this->layout->content = View::make('events.public.index')->withModels($models);
    }

    /**
     * Show event.
     *
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

    /**
     * Show event.
     *
     * @return Response
     */
    public function ics($slug)
    {
        $event = $this->repository->bySlug($slug);

        $this->calendar->add($event);

        $response = Response::make($this->calendar->render(), 200);
        $response->header('Content-Type', 'text/calendar; charset=utf-8');
        $response->header('Content-Disposition', 'attachment; filename="' . $event->slug . '.ics"');

        return $response;
    }
}
