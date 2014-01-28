<?php namespace App\Controllers\Admin;

use Controller;
use View;
use Config;
use Sentry;
use TypiCMS\Services\Helpers;


abstract class BaseController extends Controller {

	public $applicationName = 'Admin Typi CMS';

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


	private function getTitle()
	{
		$title = ucfirst($this->title['parent']);
		if ($this->title['child']) {
			$title .= ' – ' . ucfirst($this->title['child']);
		}
		$title .= ' – ' . $this->applicationName;
		return $title;
	}


	private function getH1()
	{
		return ($this->title['h1']) ? $this->title['h1'] : $this->title['child'] ;
	}


	public function __construct($repository = null, $form = null)
	{
		$this->repository = $repository;
		$this->form = $form;

		$navBar = null;
		if (Sentry::getUser()) {
			// Link to public side
			$url = array('url' => Helpers::getPublicUrl(), 'label' => 'view website');
			// Render top bar before getting current lang from url
			$navBar = View::make('_navbar')->withUrl($url)->render();
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
			$this->layout = View::make($this->layout);
		}
	}


}