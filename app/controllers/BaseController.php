<?php namespace App\Controllers;

use Controller;
use View;
use Config;
use Request;
use Route;
use App;
use DB;

use TypiCMS\Models\Menulink;
use TypiCMS\Services\ListBuilder\ListBuilder;
use Illuminate\Support\Collection;

abstract class BaseController extends Controller {

	public $applicationName;

	public $lang;

	protected $model;
	protected $mainMenu;
	protected $footerMenu;

	// The cool kids’ way of handling page titles.
	// https://gist.github.com/jonathanmarvens/6017139
	public $title  = array(
		'parent'	=> '',
		'separator' => '',
		'child'	 => '',
	);


	/**
	 * The layout that should be used for responses.
	 */
	protected $layout = 'public/master';


	public function __construct($repository = null)
	{
		$this->repository = $repository;

		// Si une langue est présente dans l'url
		if ($lang = Request::segment(1)) {

			// mettre la langue en config en fonction de l'url
			Config::set('app.contentlocale', $lang);

			$this->applicationName = Config::get('settings.website_title');

			// Main menu
			$mainMenuItems = Menulink::getMenu('main');
			$listBuilder = new ListBuilder;
			$this->mainMenu = $listBuilder->buildPublic($mainMenuItems);

			// Footer menu
			$footerMenuItems = Menulink::getMenu('footer');
			$listBuilder = new ListBuilder;
			$this->footerMenu = $listBuilder->buildPublic($footerMenuItems);

		}

		$instance = $this;

		View::composer($this->layout, function ($view) use ($instance) {
			$view->with('title', (implode(' ', $instance->title) . ' – ' . $instance->applicationName));
		});

		View::share('mainMenu', $this->mainMenu);
		View::share('footerMenu', $this->footerMenu);
		View::share('languagesMenu', $this->languagesMenu());
		View::share('lang', $lang);

	}


	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout);
		}
	}


	/**
	 * Show resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($slug)
	{
		$model = $this->repository->bySlug($slug);

		$this->title['parent'] = $model->title;
		
		$this->layout->content = View::make('public.'.$this->repository->view().'.show')
			->with('model', $model);
	}


	/**
	 * Build languages Menu.
	 *
	 * @return Collection
	 */
	private function languagesMenu()
	{
		$routeArray = explode('.',Route::currentRouteName());
		$module = isset($routeArray[1]) ? $routeArray[1] : 'pages' ;
		$segments = Request::segments();

		// dd($routeArray);

		if (end($routeArray) == 'slug') {
			// Last segment is a slug
			$slug = end($segments);
			$id = DB::table($module)
				->join($module.'_translations', $module.'.id', '=', $module.'_translations.'.str_singular($module).'_id')
				->where('slug', $slug)
				->pluck($module.'.id');
			$slugs = DB::table($module)
				->join($module.'_translations', $module.'.id', '=', $module.'_translations.'.str_singular($module).'_id')
				->where($module.'.id', $id)
				->where($module.'_translations.status', 1)
				->lists('slug', 'lang');
		}

		if (isset($routeArray[2]) and $routeArray[2] == 'categories') {
			// There is a category
			if (end($routeArray) != 'categories') {
				array_pop($segments); 
			}
			$category = end($segments);

			$id = DB::table('categories')
				->join('categories_translations', 'categories.id', '=', 'categories_translations.category_id')
				->where('slug', $category)
				->pluck('categories.id');
			$categories = DB::table($module)
				->join('categories', 'projects.category_id', '=', 'categories.id')
				->join('categories_translations', 'categories_translations.category_id', '=', 'categories.id')
				->where('categories.id', $id)
				->where('categories_translations.status', 1)
				->lists('slug', 'lang');
		}

		$languagesMenu = array();

		foreach (Config::get('app.locales') as $lg) {
			// Build translated routes
			$translatedRouteArray = $routeArray;
			$translatedRouteArray[0] = $lg;

			$translatedRouteName = implode('.', $translatedRouteArray);
			$routeParams = array();

			if (in_array('categories', $translatedRouteArray)) {
				if (isset($categories[$lg])) {
					$routeParams[] = $categories[$lg];
				} else {
					array_pop($translatedRouteArray);
				}
			}
			if (in_array('slug', $translatedRouteArray)) {
				if (isset($slugs[$lg])) {
					$routeParams[] = $slugs[$lg];
				} else {
					array_pop($translatedRouteArray);
				}
			}
			$translatedRouteName = implode('.', $translatedRouteArray);

			// single page or module index
			$route = Route::getRoutes()->get($translatedRouteName);
			// if route in this lang doesn't exist, redirect to homepage
			! $route and $translatedRouteName = $lg;

			$languagesMenu[] = (object) array(
				'lang' => $lg,
				'url' => route($translatedRouteName, $routeParams),
				'class' => Config::get('app.contentlocale') == $lg ? 'active' : ''
			);

		}

		return $languagesMenu;
	}

}