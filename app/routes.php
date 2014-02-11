<?php
if (Request::segment(1) != 'admin') {
	
	Route::bind('categories', function($value, $route){
		return TypiCMS\Modules\Categories\Models\Category::select('categories.id AS id', 'slug', 'status')
			->join('category_translations', 'categories.id', '=', 'category_translations.category_id')
			->where('slug', $value)
			->where('status', 1)
			->firstOrFail();
	});
	
}

/**
 * Admin routes.
 */
Route::group(array('prefix' => 'admin', 'before' => 'auth.admin|cache.clear'), function()
{
	Route::get('/', array('as' => 'dashboard', 'uses' => 'App\Controllers\Admin\DashboardController@index'));
	Route::get('backup', array('as' => 'backup', 'uses' => 'App\Controllers\Admin\DashboardController@backup'));

	Route::resource('settings', 'App\Controllers\Admin\SettingsController');

});


/**
 * Public routes.
 */

Route::group(array('before' => 'auth.public|cache', 'after' => 'cache'), function()
{

	// Lang chooser
	Route::get('/', array('as' => 'root', 'uses' => 'App\Controllers\PublicController@root'));

	if ( ! App::runningInConsole()) {
		
		// Build routes from Table Pages
		$queryPages = DB::table('pages')
			->select('pages.id', 'page_id', 'uri', 'locale')
			->join('page_translations', 'pages.id', '=', 'page_translations.page_id')
			->where('uri', '!=', '')
			->where('is_home', '!=', 1)
			->where('status', '=', 1)
			->orderBy('locale');

		if (Config::get('app.cachePublic')) {
			$queryPages->remember(1440);
		}

		$pages = $queryPages->get();

		foreach ($pages as $page) {
			Route::get($page->uri, array('as' => $page->locale.'.pages.'.$page->id, 'uses' => 'TypiCMS\Modules\Pages\Controllers\PagesController@uri'));
		}

		// Build routes from menulinks (modules)
		$queryMenulinks = DB::table('menulinks')
			->select('menulinks.id', 'menulink_id', 'uri', 'locale', 'module_name')
			->join('menulink_translations', 'menulinks.id', '=', 'menulink_translations.menulink_id')
			->where('uri', '!=', '')
			->where('module_name', '!=', '')
			->where('status', '=', 1)
			->orderBy('module_name');

		if (Config::get('app.cachePublic')) {
			$queryMenulinks->remember(1440);
		}

		$menulinks = $queryMenulinks->get();

		$menulinksArray = array();
		foreach ($menulinks as $menulink) {
			$menulinksArray[$menulink->module_name][$menulink->locale] = $menulink->uri;
		}

		// events routes
		// Add YYY-MM-DD in url ?
		// if (isset($menulinksArray['events'])) {
		// 	foreach ($menulinksArray['events'] as $lang => $uri) {
		// 		Route::get($uri, array('as' => $lang.'.events', 'uses' => 'App\Controllers\EventsController@index'));
		// 		Route::get($uri.'/{slug}', array('as' => $lang.'.events'.'.slug', 'uses' => 'App\Controllers\EventsController@show'));
		// 	}
		// }

		// projects routes
		if (isset($menulinksArray['projects'])) {
			foreach ($menulinksArray['projects'] as $lang => $uri) {
				Route::get($uri, array('as' => $lang.'.projects', 'uses' => 'TypiCMS\Modules\Projects\Controllers\ProjectsController@index'));
				Route::get($uri.'/{categories}', array('as' => $lang.'.projects.categories', 'uses' => 'TypiCMS\Modules\Projects\Controllers\ProjectsController@index'));
				Route::get($uri.'/{categories}/{slug}', array('as' => $lang.'.projects.categories.slug', 'uses' => 'TypiCMS\Modules\Projects\Controllers\ProjectsController@show'));
			}
			unset($menulinksArray['projects']);
		}

		// modules routes
		foreach ($menulinksArray as $module => $moduleArray) {
			foreach ($moduleArray as $lang => $uri) {
				Route::get($uri, array('as' => $lang.'.'.$module, 'uses' => 'TypiCMS\Modules\\'.ucfirst($module).'\Controllers\\'.ucfirst($module).'Controller@index'));
				Route::get($uri.'/{slug}', array('as' => $lang.'.'.$module.'.slug', 'uses' => 'TypiCMS\Modules\\'.ucfirst($module).'\Controllers\\'.ucfirst($module).'Controller@show'));
			}
		}

		// news routes (in module directory)
		if (isset($menulinksArray['news'])) {
			foreach ($menulinksArray['news'] as $lang => $uri) {
				Route::get($uri, array('as' => $lang.'.news', 'uses' => 'TypiCMS\Modules\News\Controllers\NewsController@index'));
				Route::get($uri.'/{slug}', array('as' => $lang.'.news.slug', 'uses' => 'TypiCMS\Modules\News\Controllers\NewsController@show'));
			}
			unset($menulinksArray['paces']);
		}

		// places routes (in module directory)
		if (isset($menulinksArray['places'])) {
			foreach ($menulinksArray['places'] as $lang => $uri) {
				Route::get($uri, array('as' => $lang.'.places', 'uses' => 'TypiCMS\Modules\Places\Controllers\PlacesController@index'));
				Route::get($uri.'/{slug}', array('as' => $lang.'.places.slug', 'uses' => 'TypiCMS\Modules\Places\Controllers\PlacesController@show'));
			}
			unset($menulinksArray['paces']);
		}

	}

	// Homepages (for each language)
	foreach (Config::get('app.locales') as $locale) {
		Route::get($locale, array('as' => $locale, 'uses' => 'TypiCMS\Modules\Pages\Controllers\PagesController@homepage'));
	}

});
