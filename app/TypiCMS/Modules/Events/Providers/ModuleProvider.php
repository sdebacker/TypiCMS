<?php namespace TypiCMS\Modules\Events\Providers;

use View;
use Illuminate\Support\ServiceProvider;

use TypiCMS\Modules\Events\Models\Event;
use TypiCMS\Modules\Events\Repositories\EloquentEvent;

// Cache
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

		// Add view dir
		View::addLocation(__DIR__ . '/../Views');
	}

	public function register()
	{

		$app = $this->app;

		$app->bind('TypiCMS\Modules\Events\Repositories\EventInterface', function($app)
		{
			require __DIR__ . '/../breadcrumbs.php';
			return new EloquentEvent(
				new Event,
				new LaravelCache($app['cache'], 'events', 10)
			);
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