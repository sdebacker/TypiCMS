<?php namespace TypiCMS\Modules\Places\Providers;

use View;
use Illuminate\Support\ServiceProvider;

use TypiCMS\Modules\Places\Models\Place;
use TypiCMS\Modules\Places\Repositories\EloquentPlace;

// Cache
use TypiCMS\Services\Cache\LaravelCache;

// Form
use TypiCMS\Modules\Places\Services\Form\PlaceForm;
use TypiCMS\Modules\Places\Services\Form\PlaceFormLaravelValidator;

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

		$app->bind('TypiCMS\Modules\Places\Repositories\PlaceInterface', function($app)
		{
			require __DIR__ . '/../breadcrumbs.php';
			return new EloquentPlace(
				new Place,
				new LaravelCache($app['cache'], 'places', 10)
			);
		});

		$app->bind('TypiCMS\Modules\Places\Services\Form\PlaceForm', function($app)
		{
			return new PlaceForm(
				new PlaceFormLaravelValidator( $app['validator'] ),
				$app->make('TypiCMS\Modules\Places\Repositories\PlaceInterface')
			);
		});

	}

}