<?php
namespace TypiCMS\Modules\Galleries\Providers;

use Lang;
use View;
use Config;
use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\Application;

// Models
use TypiCMS\Modules\Galleries\Models\Gallery;
use TypiCMS\Modules\Galleries\Models\GalleryTranslation;

// Repo
use TypiCMS\Modules\Galleries\Repositories\EloquentGallery;

// Cache
use TypiCMS\Modules\Galleries\Repositories\CacheDecorator;
use TypiCMS\Services\Cache\LaravelCache;

// Form
use TypiCMS\Modules\Galleries\Services\Form\GalleryForm;
use TypiCMS\Modules\Galleries\Services\Form\GalleryFormLaravelValidator;

// Observers
use TypiCMS\Observers\SlugObserver;

class ModuleProvider extends ServiceProvider
{

    public function boot()
    {
        // Bring in the routes
        require __DIR__ . '/../routes.php';

        // Add dirs
        View::addLocation(__DIR__ . '/../Views');
        Lang::addNamespace('galleries', __DIR__ . '/../lang');
        Config::addNamespace('galleries', __DIR__ . '/../config');

        // Observers
        GalleryTranslation::observe(new SlugObserver);
    }

    public function register()
    {

        $app = $this->app;

        $app->bind('TypiCMS\Modules\Galleries\Repositories\GalleryInterface', function (Application $app) {
            $repository = new EloquentGallery(new Gallery);
            if (! Config::get('app.cache')) {
                return $repository;
            }
            $laravelCache = new LaravelCache($app['cache'], ['galleries', 'files'], 10);

            return new CacheDecorator($repository, $laravelCache);
        });

        $app->bind('TypiCMS\Modules\Galleries\Services\Form\GalleryForm', function (Application $app) {
            return new GalleryForm(
                new GalleryFormLaravelValidator($app['validator']),
                $app->make('TypiCMS\Modules\Galleries\Repositories\GalleryInterface')
            );
        });

        $app->before(function ($request, $response) {
            require __DIR__ . '/../breadcrumbs.php';
        });

    }
}
