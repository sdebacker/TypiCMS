<?php namespace TypiCMS\Modules\Pages\Providers;

use View;
use Config;

use Illuminate\Support\ServiceProvider;

// Model
use TypiCMS\Modules\Pages\Models\Page;

// Repo
use TypiCMS\Modules\Pages\Repositories\EloquentPage;

// Cache
use TypiCMS\Modules\Pages\Repositories\CacheDecorator;
use TypiCMS\Services\Cache\LaravelCache;

// Form
use TypiCMS\Modules\Pages\Services\Form\PageForm;
use TypiCMS\Modules\Pages\Services\Form\PageFormLaravelValidator;

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

		$app->bind('TypiCMS\Modules\Pages\Repositories\PageInterface', function($app)
		{
			require __DIR__ . '/../breadcrumbs.php';
			$repository = new EloquentPage(new Page);
			if ( ! Config::get('app.cache')) {
				return $repository;
			}
			$laravelCache = new LaravelCache($app['cache'], 'Pages', 10);
			return new CacheDecorator($repository, $laravelCache);
		});

		$app->bind('TypiCMS\Modules\Pages\Services\Form\PageForm', function($app)
		{
			return new PageForm(
				new PageFormLaravelValidator( $app['validator'] ),
				$app->make('TypiCMS\Modules\Pages\Repositories\PageInterface')
			);
		});

	}

}