<?php
namespace TypiCMS\Controllers;

use Config;
use Controller;
use Input;
use Lang;
use Patchwork\Utf8;
use Response;
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
        $this->repository = $repository;
        $this->form = $form;

        $this->applicationName = Config::get('typicms.' . Lang::getLocale() . '.websiteTitle');

        $instance = $this;
        View::composer($this->layout, function (\Illuminate\View\View $view) use ($instance) {
            $view->with('title', $instance->getTitle());
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

    /**
     * Sort list.
     *
     * @return Response
     */
    public function sort()
    {
        $this->repository->sort(Input::all());
        return Response::json([
            'error'   => false,
            'message' => trans('global.Items sorted')
        ], 200);
    }
}
