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

use Patchwork\Utf8;

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
        $this->repository = $repository;

        $modules = TypiCMS::getModules();

        $this->applicationName = Config::get('typicms.' . App::getLocale() . '.websiteTitle');

        $instance = $this;
        View::composer($this->layout, function ($view) use ($instance) {
            $view->with('title', (Utf8::ucfirst(implode(' ', $instance->title)) . ' – ' . $instance->applicationName));
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
