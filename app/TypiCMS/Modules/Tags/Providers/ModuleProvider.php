<?php namespace TypiCMS\Modules\Tags\Providers;

use Lang;
use View;
use Config;

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

		// Add dirs
		View::addLocation(__DIR__ . '/../Views');
		Lang::addNamespace('tags', __DIR__ . '/../lang');
	}

	public function register()
	{

		$app = $this->app;

		$app->bind('TypiCMS\Modules\Tags\Repositories\TagInterface', function($app)
		{
			$repository = new EloquentTag(new Tag);
			if ( ! Config::get('app.cache')) {
				return $repository;
			}
			$laravelCache = new LaravelCache($app['cache'], 'Tags', 10);
			return new CacheDecorator($repository, $laravelCache);
		});

		$app->before(function($request, $response)
		{
			require __DIR__ . '/../breadcrumbs.php';
		});

	}

}