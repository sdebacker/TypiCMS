<?php namespace TypiCMS\Modules\Tags\Providers;

use View;
use Illuminate\Support\ServiceProvider;

// Model
use TypiCMS\Modules\Tags\Models\Tag;

// Repo
use TypiCMS\Modules\Tags\Repositories\EloquentTag;

// Cache
use TypiCMS\Modules\Tags\Repositories\CacheDecorator;
use TypiCMS\Services\Cache\LaravelCache;

class ModuleProvider extends ServiceProvider {

	public function boot()
	{
		// Bring in the routes
		require __DIR__ . '/../routes.php';

		// Add view dir
		View::addLocation(__DIR__ . '/../Views');
	}

	public function register()
	{

		$app = $this->app;

		$app->bind('TypiCMS\Modules\Tags\Repositories\TagInterface', function($app)
		{
			require __DIR__ . '/../breadcrumbs.php';
			$repository = new EloquentTag(new Tag);
			$laravelCache = new LaravelCache($app['cache'], 'Tags', 10);
			return new CacheDecorator($repository, $laravelCache);
		});

	}

}