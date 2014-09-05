<?php
namespace TypiCMS\Modules\Files\Providers;

use Lang;
use View;
use Config;
use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\Application;

// Model
use TypiCMS\Modules\Files\Models\File;

// Repo
use TypiCMS\Modules\Files\Repositories\EloquentFile;

// Cache
use TypiCMS\Modules\Files\Repositories\CacheDecorator;
use TypiCMS\Services\Cache\LaravelCache;

// Form
use TypiCMS\Modules\Files\Services\Form\FileForm;
use TypiCMS\Modules\Files\Services\Form\FileFormLaravelValidator;

// Observers
use TypiCMS\Observers\FileObserver;

class ModuleProvider extends ServiceProvider
{

    public function boot()
    {
        // Bring in the routes
        require __DIR__ . '/../routes.php';

        // Add dirs
        View::addLocation(__DIR__ . '/../Views');
        Lang::addNamespace('files', __DIR__ . '/../lang');
        Config::addNamespace('files', __DIR__ . '/../config');

        // Observers
        File::observe(new FileObserver);
    }

    public function register()
    {

        $app = $this->app;

        $app->bind('TypiCMS\Modules\Files\Repositories\FileInterface', function (Application $app) {
            $repository = new EloquentFile(new File);
            if (! Config::get('app.cache')) {
                return $repository;
            }
            $laravelCache = new LaravelCache($app['cache'], ['galleries', 'files'], 10);

            return new CacheDecorator($repository, $laravelCache);
        });

        $app->bind('TypiCMS\Modules\Files\Services\Form\FileForm', function (Application $app) {
            return new FileForm(
                new FileFormLaravelValidator($app['validator']),
                $app->make('TypiCMS\Modules\Files\Repositories\FileInterface')
            );
        });

        $app->before(function ($request, $response) {
            require __DIR__ . '/../breadcrumbs.php';
        });

    }
}
