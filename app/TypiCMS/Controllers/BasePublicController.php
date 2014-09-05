<?php
namespace TypiCMS\Controllers;

use App;
use View;
use Input;
use Sentry;
use Config;
use Controller;
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

        $this->applicationName = Config::get('typicms.' . App::getLocale() . '.websiteTitle');

        $instance = $this;
        View::composer($this->layout, function (\Illuminate\View\View $view) use ($instance) {
            $view->withTitle(Utf8::ucfirst(implode(' ', $instance->title)) . ' – ' . $instance->applicationName);
        });

        $bodyClass = ['lang-' . App::getLocale(), $repository->getModel()->getTable()];
        if (Sentry::getUser() && ! Input::get('preview')) {
            $bodyClass[] = 'has-navbar';
        }
        View::share('lang', App::getLocale());
        View::share('bodyClass', implode(' ', $bodyClass));
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
