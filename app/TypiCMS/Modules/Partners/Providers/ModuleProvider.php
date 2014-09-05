<?php
namespace TypiCMS\Modules\Partners\Providers;

use Lang;
use View;
use Config;
use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\Application;

// Model
use TypiCMS\Modules\Partners\Models\Partner;
use TypiCMS\Modules\Partners\Models\PartnerTranslation;

// Repo
use TypiCMS\Modules\Partners\Repositories\EloquentPartner;

// Cache
use TypiCMS\Modules\Partners\Repositories\CacheDecorator;
use TypiCMS\Services\Cache\LaravelCache;

// Form
use TypiCMS\Modules\Partners\Services\Form\PartnerForm;
use TypiCMS\Modules\Partners\Services\Form\PartnerFormLaravelValidator;

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
        Lang::addNamespace('partners', __DIR__ . '/../lang');
        Config::addNamespace('partners', __DIR__ . '/../config');

        // Observers
        PartnerTranslation::observe(new SlugObserver);
        Partner::observe(new FileObserver);
    }

    public function register()
    {

        $app = $this->app;

        $app->bind('TypiCMS\Modules\Partners\Repositories\PartnerInterface', function (Application $app) {
            $repository = new EloquentPartner(new Partner);
            if (! Config::get('app.cache')) {
                return $repository;
            }
            $laravelCache = new LaravelCache($app['cache'], 'partners', 10);

            return new CacheDecorator($repository, $laravelCache);
        });

        $app->bind('TypiCMS\Modules\Partners\Services\Form\PartnerForm', function (Application $app) {
            return new PartnerForm(
                new PartnerFormLaravelValidator($app['validator']),
                $app->make('TypiCMS\Modules\Partners\Repositories\PartnerInterface')
            );
        });

        $app->before(function ($request, $response) {
            require __DIR__ . '/../breadcrumbs.php';
        });

    }
}
