<?php
namespace TypiCMS\Modules\History\Providers;

use View;
use Config;
use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\Application;

// Models
use TypiCMS\Modules\History\Models\History;

// Repo
use TypiCMS\Modules\History\Repositories\EloquentHistory;

// Cache
use TypiCMS\Modules\History\Repositories\CacheDecorator;
use TypiCMS\Services\Cache\LaravelCache;

class ModuleProvider extends ServiceProvider
{

    public function boot()
    {
        // Bring in the routes
        require __DIR__ . '/../routes.php';

        // Add dirs
        View::addLocation(__DIR__ . '/../Views');
        Config::addNamespace('history', __DIR__ . '/../config');
    }

    public function register()
    {

        $app = $this->app;

        $app->bind('TypiCMS\Modules\History\Repositories\HistoryInterface', function (Application $app) {
            $repository = new EloquentHistory(new History);
            if (! Config::get('app.cache')) {
                return $repository;
            }
            $laravelCache = new LaravelCache($app['cache'], ['history'], 10);

            return new CacheDecorator($repository, $laravelCache);
        });

        $app->before(function ($request, $response) {
            require __DIR__ . '/../breadcrumbs.php';
        });

    }
}
