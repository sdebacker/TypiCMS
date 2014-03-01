<?php namespace TypiCMS\Modules\Events\Providers;

use Lang;
use View;
use Config;

use Illuminate\Support\ServiceProvider;

// Model
use TypiCMS\Modules\Events\Models\Event;

// Repo
use TypiCMS\Modules\Events\Repositories\EloquentEvent;

// Cache
use TypiCMS\Modules\Events\Repositories\CacheDecorator;
use TypiCMS\Services\Cache\LaravelCache;

// Form
use TypiCMS\Modules\Events\Services\Form\EventForm;
use TypiCMS\Modules\Events\Services\Form\EventFormLaravelValidator;

class ModuleProvider extends ServiceProvider {

	public function boot()
	{
		// Bring in the routes
		require __DIR__ . '/../routes.php';

		// Require breadcrumbs
		// require __DIR__ . '/../breadcrumbs.php';

		// Add dirs
		View::addLocation(__DIR__ . '/../Views');
		Lang::addNamespace('events', __DIR__ . '/../lang');
	}

	public function register()
	{

		$app = $this->app;

		$app->bind('TypiCMS\Modules\Events\Repositories\EventInterface', function($app)
		{
			require __DIR__ . '/../breadcrumbs.php';
			$repository = new EloquentEvent(new Event);
			if ( ! Config::get('app.cache')) {
				return $repository;
			}
			$laravelCache = new LaravelCache($app['cache'], 'Events', 10);
			return new CacheDecorator($repository, $laravelCache);
		});

		$app->bind('TypiCMS\Modules\Events\Services\Form\EventForm', function($app)
		{
			return new EventForm(
				new EventFormLaravelValidator( $app['validator'] ),
				$app->make('TypiCMS\Modules\Events\Repositories\EventInterface')
			);
		});

	}

}