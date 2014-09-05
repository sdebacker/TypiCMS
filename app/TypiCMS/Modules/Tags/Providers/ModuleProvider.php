<?php
namespace TypiCMS\Modules\Tags\Providers;

use Lang;
use View;
use Config;
use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\Application;

// Model
use TypiCMS\Modules\Tags\Models\Tag;

// Repo
use TypiCMS\Modules\Tags\Repositories\EloquentTag;

// Cache
use TypiCMS\Modules\Tags\Repositories\CacheDecorator;
use TypiCMS\Services\Cache\LaravelCache;

// Form
use TypiCMS\Modules\Tags\Services\Form\TagForm;
use TypiCMS\Modules\Tags\Services\Form\TagFormLaravelValidator;

class ModuleProvider extends ServiceProvider
{

    public function boot()
    {
        // Bring in the routes
        require __DIR__ . '/../routes.php';

        // Add dirs
        View::addLocation(__DIR__ . '/../Views');
        Lang::addNamespace('tags', __DIR__ . '/../lang');
        Config::addNamespace('tags', __DIR__ . '/../config');
    }

    public function register()
    {

        $app = $this->app;

        $app->bind('TypiCMS\Modules\Tags\Repositories\TagInterface', function (Application $app) {
            $repository = new EloquentTag(new Tag);
            if (! Config::get('app.cache')) {
                return $repository;
            }
            $laravelCache = new LaravelCache($app['cache'], 'tags', 10);

            return new CacheDecorator($repository, $laravelCache);
        });

        $app->bind('TypiCMS\Modules\Tags\Services\Form\TagForm', function (Application $app) {
            return new TagForm(
                new TagFormLaravelValidator($app['validator']),
                $app->make('TypiCMS\Modules\Tags\Repositories\TagInterface')
            );
        });

        $app->before(function ($request, $response) {
            require __DIR__ . '/../breadcrumbs.php';
        });

    }
}
