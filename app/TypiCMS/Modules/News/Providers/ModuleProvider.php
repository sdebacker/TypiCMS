<?php
namespace TypiCMS\Modules\News\Providers;

use Lang;
use View;
use Config;

use Illuminate\Support\ServiceProvider;

// Models
use TypiCMS\Modules\News\Models\News;
use TypiCMS\Modules\News\Models\NewsTranslation;

// Repo
use TypiCMS\Modules\News\Repositories\EloquentNews;

// Cache
use TypiCMS\Modules\News\Repositories\CacheDecorator;
use TypiCMS\Services\Cache\LaravelCache;

// Form
use TypiCMS\Modules\News\Services\Form\NewsForm;
use TypiCMS\Modules\News\Services\Form\NewsFormLaravelValidator;

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
        Lang::addNamespace('news', __DIR__ . '/../lang');
        Config::addNamespace('news', __DIR__ . '/../config');

        // Slug observer
        NewsTranslation::observe(new SlugObserver);
    }

    public function register()
    {

        $app = $this->app;

        $app->bind('TypiCMS\Modules\News\Repositories\NewsInterface', function ($app) {
            $repository = new EloquentNews(new News);
            if (! Config::get('app.cache')) {
                return $repository;
            }
            $laravelCache = new LaravelCache($app['cache'], 'News', 10);

            return new CacheDecorator($repository, $laravelCache);
        });

        $app->bind('TypiCMS\Modules\News\Services\Form\NewsForm', function ($app) {
            return new NewsForm(
                new NewsFormLaravelValidator($app['validator']),
                $app->make('TypiCMS\Modules\News\Repositories\NewsInterface')
            );
        });

        $app->before(function ($request, $response) {
            require __DIR__ . '/../breadcrumbs.php';
        });

    }
}
