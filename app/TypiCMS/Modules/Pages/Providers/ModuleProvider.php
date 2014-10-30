<?php
namespace TypiCMS\Modules\Pages\Providers;

use Lang;
use View;
use Config;
use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\Application;

// Model
use TypiCMS\Modules\Pages\Models\Page;
use TypiCMS\Modules\Pages\Models\PageTranslation;

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
use TypiCMS\Modules\Pages\Observers\HomePageObserver;
use TypiCMS\Modules\Pages\Observers\UriObserver;
use TypiCMS\Modules\Pages\Observers\SortObserver;

// Events
use TypiCMS\Modules\Pages\Events\ResetChildren;

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
        Page::observe(new HomePageObserver);
        Page::observe(new SortObserver);
        PageTranslation::observe(new UriObserver);
    }

    public function register()
    {

        $app = $this->app;

        /**
         * Sidebar view composer
         */
        $app->view->composer('admin._sidebar', 'TypiCMS\Modules\Pages\Composers\SideBarViewComposer');

        /**
         * Events
         */
        $app->events->subscribe(new ResetChildren);

        /**
         * Store all uris
         */
        $this->app->singleton('TypiCMS.pages.uris', function (Application $app) {
            return $app->make('TypiCMS\Modules\Pages\Repositories\PageInterface')->getAllUris();
        });

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
