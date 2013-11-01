<?php namespace TypiCMS\Repositories;

use TypiCMS\Models\Page;
use TypiCMS\Models\File;
use TypiCMS\Models\Menu;
use TypiCMS\Models\Menulink;
use TypiCMS\Models\Project;
use TypiCMS\Models\Category;
use TypiCMS\Models\User;
use TypiCMS\Models\Event;
use TypiCMS\Models\Configuration;

use TypiCMS\Repositories\Page\EloquentPage;
use TypiCMS\Repositories\File\EloquentFile;
use TypiCMS\Repositories\Menu\EloquentMenu;
use TypiCMS\Repositories\Menulink\EloquentMenulink;
use TypiCMS\Repositories\Project\EloquentProject;
use TypiCMS\Repositories\Category\EloquentCategory;
use TypiCMS\Repositories\Event\EloquentEvent;
use TypiCMS\Repositories\User\SentryUser;
use TypiCMS\Repositories\Dashboard\EloquentDashboard;
use TypiCMS\Repositories\Configuration\EloquentConfiguration;

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

		$app->bind('TypiCMS\Repositories\Page\PageInterface', function($app)
		{
			return new EloquentPage(
				new Page,
				new LaravelCache($app['cache'], 'pages', 10)
			);
		});

		$app->bind('TypiCMS\Repositories\Menu\MenuInterface', function($app)
		{
			return new EloquentMenu(
				new Menu,
				new LaravelCache($app['cache'], 'menus', 10)
			);
		});

		$app->bind('TypiCMS\Repositories\Menulink\MenulinkInterface', function($app)
		{
			return new EloquentMenulink(
				new Menulink,
				new LaravelCache($app['cache'], 'menulinks', 10)
			);
		});

		$app->bind('TypiCMS\Repositories\User\UserInterface', function($app)
		{
			return new SentryUser(
				new User
			);
		});

		$app->bind('TypiCMS\Repositories\Project\ProjectInterface', function($app)
		{
			return new EloquentProject(
				new Project,
				new LaravelCache($app['cache'], 'projects', 10)
			);
		});

		$app->bind('TypiCMS\Repositories\Category\CategoryInterface', function($app)
		{
			return new EloquentCategory(
				new Category,
				new LaravelCache($app['cache'], 'categories', 10)
			);
		});

		$app->bind('TypiCMS\Repositories\Event\EventInterface', function($app)
		{
			return new EloquentEvent(
				new Event,
				new LaravelCache($app['cache'], 'events', 10)
			);
		});

		$app->bind('TypiCMS\Repositories\File\FileInterface', function($app)
		{
			return new EloquentFile(
				new File,
				new LaravelCache($app['cache'], 'files', 10)
			);
		});

		$app->bind('TypiCMS\Repositories\Dashboard\DashboardInterface', function($app)
		{
			return new EloquentDashboard(
				new LaravelCache($app['cache'], 'dashboard', 10)
			);
		});

		$app->bind('TypiCMS\Repositories\Configuration\ConfigurationInterface', function($app)
		{
			return new EloquentConfiguration(
				new Configuration,
				new LaravelCache($app['cache'], 'configuration', 10)
			);
		});

	}

}