<?php namespace TypiCMS\Modules\Groups\Providers;

use Lang;
use View;

use Illuminate\Support\ServiceProvider;

use TypiCMS\Modules\Groups\Models\Group;
use TypiCMS\Modules\Groups\Repositories\SentryGroup;

// Form
use TypiCMS\Modules\Groups\Services\Form\GroupForm;
use TypiCMS\Modules\Groups\Services\Form\GroupFormLaravelValidator;

class ModuleProvider extends ServiceProvider {

	public function boot()
	{
		// Bring in the routes
		require __DIR__ . '/../routes.php';

		// Require breadcrumbs
		// require __DIR__ . '/../breadcrumbs.php';

		// Add dirs
		View::addLocation(__DIR__ . '/../Views');
		Lang::addNamespace('groups', __DIR__ . '/../lang');
	}

	public function register()
	{

		$app = $this->app;

		$app->bind('TypiCMS\Modules\Groups\Repositories\GroupInterface', function($app)
		{
			require __DIR__ . '/../breadcrumbs.php';
			return new SentryGroup(
				$app['sentry']
			);
		});

		$app->bind('TypiCMS\Modules\Groups\Services\Form\GroupForm', function($app)
		{
			return new GroupForm(
				new GroupFormLaravelValidator( $app['validator'] ),
				$app->make('TypiCMS\Modules\Groups\Repositories\GroupInterface')
			);
		});

	}

}