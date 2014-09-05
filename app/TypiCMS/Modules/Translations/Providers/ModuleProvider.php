<?php
namespace TypiCMS\Modules\Translations\Providers;

use Lang;
use View;
use Config;
use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\Application;

// Model
use TypiCMS\Modules\Translations\Models\Translation;

// Repo
use TypiCMS\Modules\Translations\Repositories\EloquentTranslation;

// Cache
use TypiCMS\Modules\Translations\Repositories\CacheDecorator;
use TypiCMS\Services\Cache\LaravelCache;

// Form
use TypiCMS\Modules\Translations\Services\Form\TranslationForm;
use TypiCMS\Modules\Translations\Services\Form\TranslationFormLaravelValidator;

class ModuleProvider extends ServiceProvider
{

    public function boot()
    {
        // Bring in the routes
        require __DIR__ . '/../routes.php';

        // Add dirs
        View::addLocation(__DIR__ . '/../Views');
        Lang::addNamespace('translations', __DIR__ . '/../lang');
        Config::addNamespace('translations', __DIR__ . '/../config');
    }

    public function register()
    {

        $app = $this->app;

        $app->bind('TypiCMS\Modules\Translations\Repositories\TranslationInterface', function (Application $app) {
            $repository = new EloquentTranslation(
                new Translation
            );
            if (! Config::get('app.cache')) {
                return $repository;
            }
            $laravelCache = new LaravelCache($app['cache'], 'translations', 10);

            return new CacheDecorator($repository, $laravelCache);
        });

        $app->bind('TypiCMS\Modules\Translations\Services\Form\TranslationForm', function (Application $app) {
            return new TranslationForm(
                new TranslationFormLaravelValidator($app['validator']),
                $app->make('TypiCMS\Modules\Translations\Repositories\TranslationInterface')
            );
        });

        $app->before(function ($request, $response) {
            require __DIR__ . '/../breadcrumbs.php';
        });

    }
}
