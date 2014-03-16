<?php namespace TypiCMS\Modules\Places\Providers;

use Lang;
use View;
use Config;

use Illuminate\Support\ServiceProvider;

// Model
use TypiCMS\Modules\Places\Models\Place;

// Repo
use TypiCMS\Modules\Places\Repositories\EloquentPlace;

// Cache
use TypiCMS\Modules\Places\Repositories\CacheDecorator;
use TypiCMS\Services\Cache\LaravelCache;

// Form
use TypiCMS\Modules\Places\Services\Form\PlaceForm;
use TypiCMS\Modules\Places\Services\Form\PlaceFormLaravelValidator;

class ModuleProvider extends ServiceProvider
{

    public function boot()
    {
        // Bring in the routes
        require __DIR__ . '/../routes.php';

        // Add dirs
        View::addLocation(__DIR__ . '/../Views');
        Lang::addNamespace('places', __DIR__ . '/../lang');
        Config::addNamespace('places', __DIR__ . '/../config');
    }

    public function register()
    {

        $app = $this->app;

        $app->bind('TypiCMS\Modules\Places\Repositories\PlaceInterface', function($app)
        {
            $repository = new EloquentPlace(new Place);
            if ( ! Config::get('app.cache')) {
                return $repository;
            }
            $laravelCache = new LaravelCache($app['cache'], 'Places', 10);
            return new CacheDecorator($repository, $laravelCache);
        });

        $app->bind('TypiCMS\Modules\Places\Services\Form\PlaceForm', function($app)
        {
            return new PlaceForm(
                new PlaceFormLaravelValidator( $app['validator'] ),
                $app->make('TypiCMS\Modules\Places\Repositories\PlaceInterface')
            );
        });

        $app->before(function($request, $response)
        {
            require __DIR__ . '/../breadcrumbs.php';
        });

    }

}