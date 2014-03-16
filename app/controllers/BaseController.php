<?php namespace App\Controllers;

use App;
use View;
use Sentry;
use Config;
use Request;
use Controller;

use TypiCMS\Services\Helpers;

abstract class BaseController extends Controller {

    /**
     * The layout that should be used for responses.
     */
    protected $layout = 'public/master';

    protected $repository;
    protected $presenter;

    // The cool kids’ way of handling page titles.
    // https://gist.github.com/jonathanmarvens/6017139
    public $applicationName;
    public $title  = array(
        'parent'    => '',
        'separator' => '',
        'child'     => '',
    );


    public function __construct($repository = null, $presenter = null)
    {
        $this->repository = $repository;
        $this->presenter = $presenter;

        $navBarTitle = Config::get('typicms.' . App::getLocale() . '.websiteTitle');
        $navBar = null;
        if (Sentry::getUser()) {
            // Link to admin side
            $url = array('url' => Helpers::getAdminUrl(), 'label' => 'admin side');

            $modules = array();
            foreach (Config::get('app.modules') as $module => $property) {
                if ($property['menu'] and Sentry::getUser()->hasAccess('admin.' . strtolower($module) . '.index')){
                    $modules[$module] = $property;
                }
            }
            // Render top bar before getting current lang from url
            $navBar = View::make('_navbar')
                ->with('navBarModules', $modules)
                ->withUrl($url)
                ->withTitle($navBarTitle)
                ->render();
        }

        // Set locale (taken from URL)
        $firstSegment = Request::segment(1);
        if (in_array($firstSegment, Config::get('app.locales'))) {
            App::setLocale($firstSegment);
            setlocale(LC_ALL, $firstSegment . '_' . ucfirst($firstSegment));
        }

        $this->applicationName = Config::get('typicms.' . App::getLocale() . '.websiteTitle');

        $instance = $this;
        View::composer($this->layout, function ($view) use ($instance) {
            $view->with('title', (implode(' ', $instance->title) . ' – ' . $instance->applicationName));
        });

        View::share('navBar', $navBar);
        View::share('lang', App::getLocale() );

    }


    /**
     * Setup the layout used by the controller.
     *
     * @return void
     */
    protected function setupLayout()
    {
        if ( ! is_null($this->layout)) {
            $this->layout = View::make($this->layout);
        }
    }

}