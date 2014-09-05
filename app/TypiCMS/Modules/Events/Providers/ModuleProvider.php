<?php
namespace TypiCMS\Modules\Events\Providers;

use Lang;
use View;
use Config;
use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\Application;

// Models
use TypiCMS\Modules\Events\Models\Event;
use TypiCMS\Modules\Events\Models\EventTranslation;

// Repo
use TypiCMS\Modules\Events\Repositories\EloquentEvent;

// Cache
use TypiCMS\Modules\Events\Repositories\CacheDecorator;
use TypiCMS\Services\Cache\LaravelCache;

// Form
use TypiCMS\Modules\Events\Services\Form\EventForm;
use TypiCMS\Modules\Events\Services\Form\EventFormLaravelValidator;

// Observers
use TypiCMS\Observers\SlugObserver;
use TypiCMS\Observers\FileObserver;

// Calendar
use TypiCMS\Modules\Events\Services\Calendar;
use Eluceo\iCal\Component\Calendar as EluceoCalendar;
use Eluceo\iCal\Component\Event as EluceoEvent;

class ModuleProvider extends ServiceProvider
{

    public function boot()
    {
        // Bring in the routes
        require __DIR__ . '/../routes.php';

        // Add dirs
        View::addLocation(__DIR__ . '/../Views');
        Lang::addNamespace('events', __DIR__ . '/../lang');
        Config::addNamespace('events', __DIR__ . '/../config');

        // Observers
        EventTranslation::observe(new SlugObserver);
        Event::observe(new FileObserver);
    }

    public function register()
    {

        $app = $this->app;

        $app->bind('TypiCMS\Modules\Events\Repositories\EventInterface', function (Application $app) {
            $repository = new EloquentEvent(new Event);
            if (! Config::get('app.cache')) {
                return $repository;
            }
            $laravelCache = new LaravelCache($app['cache'], 'events', 10);

            return new CacheDecorator($repository, $laravelCache);
        });

        $app->bind('TypiCMS\Modules\Events\Services\Form\EventForm', function (Application $app) {
            return new EventForm(
                new EventFormLaravelValidator($app['validator']),
                $app->make('TypiCMS\Modules\Events\Repositories\EventInterface')
            );
        });

        $app->bind('TypiCMS\Modules\Events\Services\Calendar', function (Application $app) {
            return new Calendar(
                new EluceoCalendar('TypiCMS'),
                new EluceoEvent
            );
        });

        $app->before(function ($request, $response) {
            require __DIR__ . '/../breadcrumbs.php';
        });

    }
}
