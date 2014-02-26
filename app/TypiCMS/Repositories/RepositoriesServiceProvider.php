<?php namespace TypiCMS\Repositories;

use Config;

use Illuminate\Support\ServiceProvider;

use TypiCMS\Models\Setting;

// Cache
use TypiCMS\Repositories\Dashboard\CacheDecorator as DashboardCacheDecorator;
use TypiCMS\Repositories\Setting\CacheDecorator;
use TypiCMS\Services\Cache\LaravelCache;

use TypiCMS\Repositories\Dashboard\EloquentDashboard;
use TypiCMS\Repositories\Setting\EloquentSetting;

class RepositoriesServiceProvider extends ServiceProvider {

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$app = $this->app;

		$app->bind('TypiCMS\Repositories\Dashboard\DashboardInterface', function($app)
		{
			$repository = new EloquentDashboard();
			if ( ! Config::get('app.cache')) {
				return $repository;
			}
			$laravelCache = new LaravelCache($app['cache'], 'Dashboard', 10);
			return new DashboardCacheDecorator($repository, $laravelCache);
		});

		$app->bind('TypiCMS\Repositories\Setting\SettingInterface', function($app)
		{
			$repository = new EloquentSetting(new Setting);
			if ( ! Config::get('app.cache')) {
				return $repository;
			}
			$laravelCache = new LaravelCache($app['cache'], 'Settings', 10);
			return new CacheDecorator($repository, $laravelCache);
		});

	}

}