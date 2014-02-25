<?php namespace TypiCMS\Modules\Menulinks\Providers;

use View;
use Config;

use Illuminate\Support\ServiceProvider;

// Model
use TypiCMS\Modules\Menulinks\Models\Menulink;

// Repo
use TypiCMS\Modules\Menulinks\Repositories\EloquentMenulink;

// Cache
use TypiCMS\Modules\Menulinks\Repositories\CacheDecorator;
use TypiCMS\Services\Cache\LaravelCache;

// Form
use TypiCMS\Modules\Menulinks\Services\Form\MenulinkForm;
use TypiCMS\Modules\Menulinks\Services\Form\MenulinkFormLaravelValidator;

class ModuleProvider extends ServiceProvider {

	public function boot()
	{
		// Bring in the routes
		require __DIR__ . '/../routes.php';

		// Require breadcrumbs
		// require __DIR__ . '/../breadcrumbs.php';

		// Add view dir
		View::addLocation(__DIR__ . '/../Views');
	}

	public function register()
	{

		$app = $this->app;

		$app->bind('TypiCMS\Modules\Menulinks\Repositories\MenulinkInterface', function($app)
		{
			require __DIR__ . '/../breadcrumbs.php';
			$repository = new EloquentMenulink(new Menulink);
			if ( ! Config::get('app.cachePublic')) {
				return $repository;
			}
			$laravelCache = new LaravelCache($app['cache'], 'Menulinks', 10);
			return new CacheDecorator($repository, $laravelCache);
		});

		$app->bind('TypiCMS\Modules\Menulinks\Services\Form\MenulinkForm', function($app)
		{
			return new MenulinkForm(
				new MenulinkFormLaravelValidator( $app['validator'] ),
				$app->make('TypiCMS\Modules\Menulinks\Repositories\MenulinkInterface')
			);
		});

	}

}