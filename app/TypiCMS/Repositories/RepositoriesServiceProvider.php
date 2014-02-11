<?php namespace TypiCMS\Repositories;

use TypiCMS\Models\User;
use TypiCMS\Models\Setting;

use TypiCMS\Repositories\User\SentryUser;
use TypiCMS\Repositories\Dashboard\EloquentDashboard;
use TypiCMS\Repositories\Setting\EloquentSetting;

use TypiCMS\Services\Cache\LaravelCache;
use Illuminate\Support\ServiceProvider;

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
			return new EloquentDashboard(
				new LaravelCache($app['cache'], 'dashboard', 10)
			);
		});

		$app->bind('TypiCMS\Repositories\Setting\SettingInterface', function($app)
		{
			return new EloquentSetting(
				new Setting,
				new LaravelCache($app['cache'], 'configuration', 10)
			);
		});

	}

}