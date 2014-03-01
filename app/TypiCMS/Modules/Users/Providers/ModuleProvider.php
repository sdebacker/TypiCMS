<?php namespace TypiCMS\Modules\Users\Providers;

use Lang;
use View;

use Illuminate\Support\ServiceProvider;

// use TypiCMS\Modules\Users\Models\User;
use TypiCMS\Modules\Users\Repositories\SentryUser;

// Form
use TypiCMS\Modules\Users\Services\Form\UserForm;
use TypiCMS\Modules\Users\Services\Form\UserFormLaravelValidator;

class ModuleProvider extends ServiceProvider {

	public function boot()
	{
		// Bring in the routes
		require __DIR__ . '/../routes.php';

		// Require breadcrumbs
		// require __DIR__ . '/../breadcrumbs.php';

		// Add dirs
		View::addLocation(__DIR__ . '/../Views');
		Lang::addNamespace('users', __DIR__ . '/../lang');
	}

	public function register()
	{

		$app = $this->app;

		$app->bind('TypiCMS\Modules\Users\Repositories\UserInterface', function($app)
		{
			require __DIR__ . '/../breadcrumbs.php';
			return new SentryUser(
				$app['sentry']
			);
		});

		$app->bind('TypiCMS\Modules\Users\Services\Form\UserForm', function($app)
		{
			return new UserForm(
				new UserFormLaravelValidator( $app['validator'] ),
				$app->make('TypiCMS\Modules\Users\Repositories\UserInterface')
			);
		});

	}

}