<?php namespace TypiCMS\Modules\Projects\Providers;

use View;
use Illuminate\Support\ServiceProvider;

use TypiCMS\Modules\Projects\Models\Project;
use TypiCMS\Modules\Tags\Models\TagInterface;
use TypiCMS\Modules\Projects\Repositories\EloquentProject;

// Cache
use TypiCMS\Services\Cache\LaravelCache;

// Form
use TypiCMS\Modules\Projects\Services\Form\ProjectForm;
use TypiCMS\Modules\Projects\Services\Form\ProjectFormLaravelValidator;

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

		$app->bind('TypiCMS\Modules\Projects\Repositories\ProjectInterface', function($app)
		{
			require __DIR__ . '/../breadcrumbs.php';
			return new EloquentProject(
				new Project,
				new LaravelCache($app['cache'], 'places', 10),
				$app->make('TypiCMS\Modules\Tags\Repositories\TagInterface')
			);
		});

		$app->bind('TypiCMS\Modules\Projects\Services\Form\ProjectForm', function($app)
		{
			return new ProjectForm(
				new ProjectFormLaravelValidator( $app['validator'] ),
				$app->make('TypiCMS\Modules\Projects\Repositories\ProjectInterface')
			);
		});

	}

}