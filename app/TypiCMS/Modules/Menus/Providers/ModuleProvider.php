<?php
namespace TypiCMS\Modules\Menus\Providers;

use Lang;
use View;
use Config;
use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\Application;

// Model
use TypiCMS\Modules\Menus\Models\Menu;

// Repo
use TypiCMS\Modules\Menus\Repositories\EloquentMenu;

// Cache
use TypiCMS\Modules\Menus\Repositories\CacheDecorator;
use TypiCMS\Services\Cache\LaravelCache;

// Form
use TypiCMS\Modules\Menus\Services\Form\MenuForm;
use TypiCMS\Modules\Menus\Services\Form\MenuFormLaravelValidator;

class ModuleProvider extends ServiceProvider
{

    public function boot()
    {
        // Bring in the routes
        require __DIR__ . '/../routes.php';

        // Add dirs
        View::addLocation(__DIR__ . '/../Views');
        Lang::addNamespace('menus', __DIR__ . '/../lang');
        Config::addNamespace('menus', __DIR__ . '/../config');
    }

    public function register()
    {

        $app = $this->app;

        $app->bind('TypiCMS\Modules\Menus\Repositories\MenuInterface', function (Application $app) {
            $repository = new EloquentMenu(new Menu);
            if (! Config::get('app.cache')) {
                return $repository;
            }
            $laravelCache = new LaravelCache($app['cache'], ['menus', 'menulinks', 'pages'], 10);

            return new CacheDecorator($repository, $laravelCache);
        });

        $app->bind('TypiCMS\Modules\Menus\Services\Form\MenuForm', function (Application $app) {
            return new MenuForm(
                new MenuFormLaravelValidator($app['validator']),
                $app->make('TypiCMS\Modules\Menus\Repositories\MenuInterface')
            );
        });

        /*
        |--------------------------------------------------------------------------
        | Get all menus.
        |--------------------------------------------------------------------------|
        */
        $this->app['TypiCMS.menus'] = $this->app->share(function (Application $app) {
            return $app->make('TypiCMS\Modules\Menus\Repositories\MenuInterface')->getAllMenus();
        });

        $app->before(function ($request, $response) {
            require __DIR__ . '/../breadcrumbs.php';
        });

    }
}
