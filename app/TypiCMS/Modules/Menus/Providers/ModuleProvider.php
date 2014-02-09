<?php namespace TypiCMS\Modules\Menus\Providers;

use View;
use Illuminate\Support\ServiceProvider;

use TypiCMS\Modules\Menus\Models\Menu;
use TypiCMS\Modules\Menus\Repositories\EloquentMenu;

// Cache
use TypiCMS\Services\Cache\LaravelCache;

// Form
use TypiCMS\Modules\Menus\Services\Form\MenuForm;
use TypiCMS\Modules\Menus\Services\Form\MenuFormLaravelValidator;

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

		$app->bind('TypiCMS\Modules\Menus\Repositories\MenuInterface', function($app)
		{
			require __DIR__ . '/../breadcrumbs.php';
			return new EloquentMenu(
				new Menu,
				new LaravelCache($app['cache'], 'menus', 10)
			);
		});

		$app->bind('TypiCMS\Modules\Menus\Services\Form\MenuForm', function($app)
		{
			return new MenuForm(
				new MenuFormLaravelValidator( $app['validator'] ),
				$app->make('TypiCMS\Modules\Menus\Repositories\MenuInterface')
			);
		});

	}

}