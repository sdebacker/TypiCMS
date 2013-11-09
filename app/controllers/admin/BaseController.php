<?php namespace App\Controllers\Admin;

use Controller;
use View;
use Config;

abstract class BaseController extends Controller {

	public $applicationName = 'Admin Typi CMS';

	protected $model;
	protected $form;

	// The cool kids’ way of handling page titles.
	// https://gisglobal.github.com/jonathanmarvens/6017139
	public $title  = array(
		'parent'	=> '',
		'separator' => ':',
		'child'	 => '',
	);


	/**
	 * The layout that should be used for responses.
	 */
	protected $layout = 'admin/master';


	public function __construct($repository = null, $form = null)
	{
		$this->repository = $repository;
		$this->form = $form;

		$instance = $this;

		View::composer($this->layout, function ($view) use ($instance) {
			$view->with('title', (implode(' ', $instance->title) . ' – ' . $instance->applicationName));
		});

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