<?php namespace TypiCMS\Modules\Categories\Providers;

use View;
use Illuminate\Support\ServiceProvider;

use TypiCMS\Modules\Categories\Models\Category;
use TypiCMS\Modules\Categories\Repositories\EloquentCategory;

// Cache
use TypiCMS\Services\Cache\LaravelCache;

// Form
use TypiCMS\Modules\Categories\Services\Form\CategoryForm;
use TypiCMS\Modules\Categories\Services\Form\CategoryFormLaravelValidator;

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

		$app->bind('TypiCMS\Modules\Categories\Repositories\CategoryInterface', function($app)
		{
			require __DIR__ . '/../breadcrumbs.php';
			return new EloquentCategory(
				new Category,
				new LaravelCache($app['cache'], 'categories', 10)
			);
		});

		$app->bind('TypiCMS\Modules\Categories\Services\Form\CategoryForm', function($app)
		{
			return new CategoryForm(
				new CategoryFormLaravelValidator( $app['validator'] ),
				$app->make('TypiCMS\Modules\Categories\Repositories\CategoryInterface')
			);
		});

	}

}