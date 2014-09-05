<?php
namespace TypiCMS\Modules\Blocks\Providers;

use Lang;
use View;
use Config;
use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\Application;

// Model
use TypiCMS\Modules\Blocks\Models\Block;

// Repo
use TypiCMS\Modules\Blocks\Repositories\EloquentBlock;

// Cache
use TypiCMS\Modules\Blocks\Repositories\CacheDecorator;
use TypiCMS\Services\Cache\LaravelCache;

// Form
use TypiCMS\Modules\Blocks\Services\Form\BlockForm;
use TypiCMS\Modules\Blocks\Services\Form\BlockFormLaravelValidator;

class ModuleProvider extends ServiceProvider
{

    public function boot()
    {
        // Bring in the routes
        require __DIR__ . '/../routes.php';

        // Add dirs
        View::addLocation(__DIR__ . '/../Views');
        Lang::addNamespace('blocks', __DIR__ . '/../lang');
        Config::addNamespace('blocks', __DIR__ . '/../config');
    }

    public function register()
    {

        $app = $this->app;

        $app->bind('TypiCMS\Modules\Blocks\Repositories\BlockInterface', function (Application $app) {
            $repository = new EloquentBlock(new Block);
            if (! Config::get('app.cache')) {
                return $repository;
            }
            $laravelCache = new LaravelCache($app['cache'], 'blocks', 10);

            return new CacheDecorator($repository, $laravelCache);
        });

        $app->bind('TypiCMS\Modules\Blocks\Services\Form\BlockForm', function (Application $app) {
            return new BlockForm(
                new BlockFormLaravelValidator($app['validator']),
                $app->make('TypiCMS\Modules\Blocks\Repositories\BlockInterface')
            );
        });

        $app->before(function ($request, $response) {
            require __DIR__ . '/../breadcrumbs.php';
        });

    }
}
