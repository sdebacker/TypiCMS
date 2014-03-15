<?php namespace TypiCMS\Modules\Places\Controllers;

use Str;
use View;
use Request;
use Response;

use TypiCMS\Modules\Places\Repositories\PlaceInterface;

// Presenter
use TypiCMS\Presenters\Presenter;
use TypiCMS\Modules\Places\Presenters\PlacePresenter;

// Base controller
use App\Controllers\BaseController;

class PlacesController extends BaseController {

    public function __construct(PlaceInterface $place, Presenter $presenter)
    {
        parent::__construct($place, $presenter);
        $this->title['parent'] = Str::title(trans_choice('places::global.places', 2));
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $this->title['child'] = '';

        $places = $this->repository->getAll();
        
        if (Request::wantsJson()) {
            return Response::json($places, 200);
        }

        $this->layout->content = View::make('places.public.index')
            ->withPlaces($places);
    }

    /**
     * Display resources found.
     *
     * @return Response
     */
    public function search()
    {

        $models = $this->repository->getAll();
        
        if (Request::wantsJson()) {
            return Response::json($models, 200);
        }

        $this->layout->content = View::make('places.public.results')
            ->with('models', $models);
    }

    /**
     * Show place.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($slug)
    {
        $model = $this->repository->bySlug($slug);

        // dd($model->toJson());
        if (Request::wantsJson()) {
            return Response::json($model, 200);
        }

        $this->title['parent'] = $model->title;
        
        return View::make('places.public.show')
            ->with('model', $model);
    }

}