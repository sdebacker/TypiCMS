<?php
namespace TypiCMS\Modules\Groups\Providers;

use Lang;
use View;
use Config;
use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\Application;
use TypiCMS\Modules\Groups\Repositories\SentryGroup;

// Form
use TypiCMS\Modules\Groups\Services\Form\GroupForm;
use TypiCMS\Modules\Groups\Services\Form\GroupFormLaravelValidator;

class ModuleProvider extends ServiceProvider
{

    public function boot()
    {
        // Bring in the routes
        require __DIR__ . '/../routes.php';

        // Add dirs
        View::addLocation(__DIR__ . '/../Views');
        Lang::addNamespace('groups', __DIR__ . '/../lang');
        Config::addNamespace('groups', __DIR__ . '/../config');
    }

    public function register()
    {

        $app = $this->app;

        $app->bind('TypiCMS\Modules\Groups\Repositories\GroupInterface', function (Application $app) {
            return new SentryGroup(
                $app['sentry']
            );
        });

        $app->bind('TypiCMS\Modules\Groups\Services\Form\GroupForm', function (Application $app) {
            return new GroupForm(
                new GroupFormLaravelValidator($app['validator']),
                $app->make('TypiCMS\Modules\Groups\Repositories\GroupInterface')
            );
        });

        $app->before(function ($request, $response) {
            require __DIR__ . '/../breadcrumbs.php';
        });

    }
}
