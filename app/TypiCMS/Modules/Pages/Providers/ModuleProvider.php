<?php
namespace TypiCMS\Modules\Pages\Providers;

use Lang;
use View;
use Config;
use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\Application;

// Model
use TypiCMS\Modules\Pages\Models\Page;

// Repo
use TypiCMS\Modules\Pages\Repositories\EloquentPage;

// Cache
use TypiCMS\Modules\Pages\Repositories\CacheDecorator;
use TypiCMS\Services\Cache\LaravelCache;

// Form
use TypiCMS\Modules\Pages\Services\Form\PageForm;
use TypiCMS\Modules\Pages\Services\Form\PageFormLaravelValidator;

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
        Lang::addNamespace('pages', __DIR__ . '/../lang');
        Config::addNamespace('pages', __DIR__ . '/../config');

        // Observers
        Page::observe(new FileObserver);
    }

    public function register()
    {

        $app = $this->app;

        $app->bind('TypiCMS\Modules\Pages\Repositories\PageInterface', function (Application $app) {
            $repository = new EloquentPage(new Page);
            if (! Config::get('app.cache')) {
                return $repository;
            }
            $laravelCache = new LaravelCache($app['cache'], ['pages', 'galleries'], 10);

            return new CacheDecorator($repository, $laravelCache);
        });

        $app->bind('TypiCMS\Modules\Pages\Services\Form\PageForm', function (Application $app) {
            return new PageForm(
                new PageFormLaravelValidator($app['validator']),
                $app->make('TypiCMS\Modules\Pages\Repositories\PageInterface')
            );
        });

        $app->before(function ($request, $response) {
            require __DIR__ . '/../breadcrumbs.php';
        });

    }
}
