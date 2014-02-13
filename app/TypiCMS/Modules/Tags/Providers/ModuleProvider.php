<?php namespace TypiCMS\Modules\Tags\Providers;

use Illuminate\Support\ServiceProvider;

use TypiCMS\Modules\Tags\Repositories\EloquentTag;
use TypiCMS\Modules\Tags\Models\Tag;
use TypiCMS\Services\Cache\LaravelCache;

class ModuleProvider extends ServiceProvider {

	public function boot()
	{
		// Bring in the routes
		require __DIR__ . '/../routes.php';
	}

	public function register()
	{

		$app = $this->app;

		$app->bind('TypiCMS\Modules\Tags\Repositories\TagInterface', function($app)
		{
			return new EloquentTag(
				new Tag,
				new LaravelCache($app['cache'], 'tags', 10)
			);
		});

	}

}