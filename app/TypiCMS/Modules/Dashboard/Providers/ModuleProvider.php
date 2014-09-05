<?php
namespace TypiCMS\Modules\Dashboard\Providers;

use Lang;
use View;
use Config;
use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\Application;

// Repo
use TypiCMS\Modules\Dashboard\Repositories\EloquentDashboard;

// Cache
use TypiCMS\Modules\Dashboard\Repositories\CacheDecorator;
use TypiCMS\Services\Cache\LaravelCache;

class ModuleProvider extends ServiceProvider
{

    public function boot()
    {
        // Bring in the routes
        require __DIR__ . '/../routes.php';

        // Add dirs
        View::addLocation(__DIR__ . '/../Views');
        Lang::addNamespace('dashboard', __DIR__ . '/../lang');
        Config::addNamespace('dashboard', __DIR__ . '/../config');
    }

    public function register()
    {

        $app = $this->app;

        $app->bind('TypiCMS\Modules\Dashboard\Repositories\DashboardInterface', function (Application $app) {
            $repository = new EloquentDashboard();
            if (! Config::get('app.cache')) {
                return $repository;
            }
            $laravelCache = new LaravelCache($app['cache'], 'dashboard', 10);

            return new CacheDecorator($repository, $laravelCache);
        });

        $app->before(function ($request, $response) {
            require __DIR__ . '/../breadcrumbs.php';
        });

    }
}
