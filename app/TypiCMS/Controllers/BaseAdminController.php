<?php
namespace TypiCMS\Controllers;

use Config;
use Controller;
use Lang;
use Patchwork\Utf8;
use Request;
use View;

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

        $this->repository = $repository;
        $this->form       = $form;

        $this->applicationName = Config::get('typicms.' . Lang::getLocale() . '.websiteTitle');

        $instance = $this;
        View::composer($this->layout, function (\Illuminate\View\View $view) use ($instance) {
            $view->with('title', $instance->getTitle());
            $view->with('h1', $instance->getH1());
        });

        View::share('locales', Config::get('app.locales'));
        View::share('locale', Config::get('app.locale'));
    }

    public function getTitle()
    {
        $title = Utf8::ucfirst($this->title['parent']);
        if ($this->title['child']) {
            $title .= ' – ' . Utf8::ucfirst($this->title['child']);
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
