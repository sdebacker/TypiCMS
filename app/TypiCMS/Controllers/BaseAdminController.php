<?php
namespace TypiCMS\Controllers;

use Lang;
use View;
use Event;
use Sentry;
use Config;
use Request;
use Controller;

use TypiCMS;

abstract class BaseAdminController extends Controller
{

    /**
     * The layout that should be used for responses.
     */
    protected $layout = 'admin/master';

    protected $repository;
    protected $form;

    // The cool kids’ way of handling page titles.
    // https://gisglobal.github.com/jonathanmarvens/6017139
    public $applicationName;
    public $title  = array(
        'parent'   => '',
        'child'    => '',
        'h1'       => '',
    );

    public function __construct($repository = null, $form = null)
    {
        // Uncomment this if you want to use clockwork

        // $this->beforeFilter(function () {
        //     Event::fire('clockwork.controller.start');
        // });

        // $this->afterFilter(function () {
        //     Event::fire('clockwork.controller.end');
        // });

        $this->repository = $repository;
        $this->form       = $form;

        $this->applicationName = Config::get('typicms.' . Lang::getLocale() . '.websiteTitle');

        $modules = TypiCMS::getModules();

        $instance = $this;
        View::composer($this->layout, function ($view) use ($instance) {
            $view->with('title', $instance->getTitle());
            $view->with('h1', $instance->getH1());
        });

        View::share('modules', $modules);
        View::share('locales', Config::get('app.locales'));
        View::share('locale', Config::get('app.locale'));
    }

    public function getTitle()
    {
        $title = ucfirst($this->title['parent']);
        if ($this->title['child']) {
            $title .= ' – ' . ucfirst($this->title['child']);
        }
        $title .= ' – ' . $this->applicationName;

        return $title;
    }

    public function getH1()
    {
        return $this->title['h1'] ? : $this->title['child'] ;
    }

    /**
     * Setup the layout used by the controller.
     *
     * @return void
     */
    protected function setupLayout()
    {
        if (! is_null($this->layout)) {
            $layout = Request::ajax() ? 'admin/ajax' : $this->layout;
            $this->layout = View::make($layout);
        }
    }
}
