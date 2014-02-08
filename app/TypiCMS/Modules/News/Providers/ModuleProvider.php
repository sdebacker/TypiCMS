<?php namespace TypiCMS\Modules\News\Providers;

use View;
use Illuminate\Support\ServiceProvider;

use TypiCMS\Modules\News\Models\News;
use TypiCMS\Modules\News\Repositories\EloquentNews;

// Cache
use TypiCMS\Services\Cache\LaravelCache;

// Form
use TypiCMS\Modules\News\Services\Form\NewsForm;
use TypiCMS\Modules\News\Services\Form\NewsFormLaravelValidator;

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

		$app->bind('TypiCMS\Modules\News\Repositories\NewsInterface', function($app)
		{
			require __DIR__ . '/../breadcrumbs.php';
			return new EloquentNews(
				new News,
				new LaravelCache($app['cache'], 'news', 10)
			);
		});

		$app->bind('TypiCMS\Modules\News\Services\Form\NewsForm', function($app)
		{
			return new NewsForm(
				new NewsFormLaravelValidator( $app['validator'] ),
				$app->make('TypiCMS\Modules\News\Repositories\NewsInterface')
			);
		});

	}

}