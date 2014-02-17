<?php namespace App\Controllers\Admin;

use Controller;
use View;
use Config;
use Sentry;
use Request;
use Lang;
use TypiCMS\Services\Helpers;


abstract class BaseController extends Controller {

	public $applicationName;

	protected $repository;
	protected $form;

	/**
	 * The layout that should be used for responses.
	 */
	protected $layout = 'admin/master';

	// The cool kids’ way of handling page titles.
	// https://gisglobal.github.com/jonathanmarvens/6017139
	public $title  = array(
		'parent'   => '',
		'child'    => '',
		'h1'       => '',
	);


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


	public function __construct($repository = null, $form = null)
	{
		$this->repository = $repository;
		$this->form = $form;
		
		// App::getLocale() and Config::get('app.locale') is set by Input::get('locale') (cf. global.php)
		// Lang::getLocale() is default value for admin interface
		$this->applicationName = Config::get('typicms.' . Lang::getLocale() . '.websiteTitle');

		$navBar = null;
		if (Sentry::getUser()) {
			// Link to public side
			$url = array('url' => Helpers::getPublicUrl(), 'label' => 'view website');

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
				->withTitle($this->applicationName)
				->render();
		}

		$instance = $this;
		View::composer($this->layout, function ($view) use ($instance) {
			$view->with('title', $instance->getTitle());
			$view->with('h1', $instance->getH1());
		});

		View::share('navBar', $navBar);
		View::share('locales', Config::get('app.locales'));
		View::share('locale', Config::get('app.locale'));
	}


	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
		{
			$layout = Request::ajax() ? 'admin/ajax' : $this->layout;
			$this->layout = View::make($layout);
		}
	}


}