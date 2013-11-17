<?php namespace TypiCMS\Services;

use Route;
use Request;
use DB;
use Config;

class MenuBuilder {
	
	public function __construct()
	{
	}

	/**
	 * Build languages Menu.
	 *
	 * @return Collection
	 */
	public function languagesMenu()
	{

		$routeArray = explode('.', Route::currentRouteName());
		// Laravel 4.1 : 
		// $routeArray = explode('.', Route::current()->getName());

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

		if (count(Config::get('app.locales')) > 1) {

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
					'class' => Config::get('app.locale') == $lg ? 'active' : ''
				);

			}

		}

		return $languagesMenu;

	}

}
