<?php namespace TypiCMS\Modules\Places\Controllers;

use View;
use Request;
use App;
use Config;
use TypiCMS\Modules\Places\Repositories\PlaceInterface;

class PlacesController extends BaseController {

	public function __construct(PlaceInterface $place)
	{
		parent::__construct($place);
		$this->title['parent'] = trans_choice('global.modules.places', 2);
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index($chapter = null, $category = null, $subcategory = null)
	{

		$chapter->id    != $category->parent         and App::abort(404);
		$chapter->lang  != Config::get('app.locale') and App::abort(404);
		$category->lang != Config::get('app.locale') and App::abort(404);

		// d($subcategory);

		$this->title['child'] = '';

		$places = $this->repository->getAll(false, $category->id);
		
		if (Request::wantsJson()) {
			return $places;
		}

		$this->layout->content = View::make('public.places.index')
			->withChapter($chapter)
			->withCategory($category)
			->withSubcategories($this->repository->getSubcategories($category->id))
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
			return $models;
		}

		$this->layout->content = View::make('public.places.results')
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
			return $model;
		}

		$this->title['parent'] = $model->title;
		
		return View::make('public.places.show')
			->with('model', $model);
	}

}