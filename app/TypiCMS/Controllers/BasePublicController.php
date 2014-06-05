<?php
namespace TypiCMS\Controllers;

use App;
use View;
use Event;
use Sentry;
use Config;
use Request;
use Controller;

use TypiCMS;

abstract class BasePublicController extends Controller
{

    /**
     * The layout that should be used for responses.
     */
    protected $layout = 'public/master';

    protected $repository;

    // The cool kids’ way of handling page titles.
    // https://gist.github.com/jonathanmarvens/6017139
    public $applicationName;
    public $title  = array(
        'parent'    => '',
        'separator' => '',
        'child'     => '',
    );

    public function __construct($repository = null)
    {
        $this->beforeFilter(function () {
            Event::fire('clockwork.controller.start');
        });

        $this->afterFilter(function () {
            Event::fire('clockwork.controller.end');
        });

        $this->repository = $repository;

        $modules = TypiCMS::getModules();

        // Set locale (taken from URL)
        $firstSegment = Request::segment(1);
        if (in_array($firstSegment, Config::get('app.locales'))) {
            App::setLocale($firstSegment);
        }
        // Not very reliable, need to be refactored
        setlocale(LC_ALL, App::getLocale() . '_' . ucfirst(App::getLocale()));

        $this->applicationName = Config::get('typicms.' . App::getLocale() . '.websiteTitle');

        $instance = $this;
        View::composer($this->layout, function ($view) use ($instance) {
            $view->with('title', (implode(' ', $instance->title) . ' – ' . $instance->applicationName));
        });

        View::share('modules', $modules);
        View::share('lang', App::getLocale());

    }

    /**
     * Setup the layout used by the controller.
     *
     * @return void
     */
    protected function setupLayout()
    {
        if (! is_null($this->layout)) {
            $this->layout = View::make($this->layout);
        }
    }
}
