<?php
namespace TypiCMS\Modules\Categories\Providers;

use Lang;
use View;
use Config;
use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\Application;

// Models
use TypiCMS\Modules\Categories\Models\Category;
use TypiCMS\Modules\Categories\Models\CategoryTranslation;

// Repo
use TypiCMS\Modules\Categories\Repositories\EloquentCategory;

// Cache
use TypiCMS\Modules\Categories\Repositories\CacheDecorator;
use TypiCMS\Services\Cache\LaravelCache;

// Form
use TypiCMS\Modules\Categories\Services\Form\CategoryForm;
use TypiCMS\Modules\Categories\Services\Form\CategoryFormLaravelValidator;

// Observers
use TypiCMS\Observers\SlugObserver;
use TypiCMS\Observers\FileObserver;

class ModuleProvider extends ServiceProvider
{

    public function boot()
    {
        // Bring in the routes
        require __DIR__ . '/../routes.php';

        // Add dirs
        View::addLocation(__DIR__ . '/../Views');
        Lang::addNamespace('categories', __DIR__ . '/../lang');
        Config::addNamespace('categories', __DIR__ . '/../config');

        // Observers
        CategoryTranslation::observe(new SlugObserver);
        Category::observe(new FileObserver);
    }

    public function register()
    {

        $app = $this->app;

        $app->bind('TypiCMS\Modules\Categories\Repositories\CategoryInterface', function (Application $app) {
            $repository = new EloquentCategory(new Category);
            if (! Config::get('app.cache')) {
                return $repository;
            }
            $laravelCache = new LaravelCache($app['cache'], 'categories', 10);

            return new CacheDecorator($repository, $laravelCache);
        });

        $app->bind('TypiCMS\Modules\Categories\Services\Form\CategoryForm', function (Application $app) {
            return new CategoryForm(
                new CategoryFormLaravelValidator($app['validator']),
                $app->make('TypiCMS\Modules\Categories\Repositories\CategoryInterface')
            );
        });

        $app->before(function ($request, $response) {
            require __DIR__ . '/../breadcrumbs.php';
        });

    }
}
