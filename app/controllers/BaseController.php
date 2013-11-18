<?php namespace App\Controllers;

use Controller;
use View;
use Config;
use App;
use Sentry;
use Request;

use TypiCMS\Models\Menulink;
use TypiCMS\Services\Helpers;
use TypiCMS\Services\MenuBuilder;
use TypiCMS\Services\ListBuilder\ListBuilder;
use Illuminate\Support\Collection;

abstract class BaseController extends Controller {

	/**
	 * The layout that should be used for responses.
	 */
	protected $layout = 'public/master';

	// The cool kids’ way of handling page titles.
	// https://gist.github.com/jonathanmarvens/6017139
	public $applicationName;
	public $title  = array(
		'parent'	=> '',
		'separator' => '',
		'child'	 => '',
	);


	public function __construct($repository = null)
	{
		$this->repository = $repository;

		$this->applicationName = Config::get('settings.website_title');

		$navBar = null;
		if (Sentry::getUser()) {
			// Link to admin side
			$url = array('url' => Helpers::getAdminUrl(), 'label' => 'edit page');
			// Render top bar before getting current lang from url
			$navBar = View::make('_navbar')->withUrl($url)->render();
		}

		// Set locale (taken from URL)
		$firstSegment = Request::segment(1);
		if (in_array($firstSegment, Config::get('app.locales'))) {
			App::setLocale($firstSegment);
		}

		$menuBuilder = new MenuBuilder;

		// Main menu
		$mainMenuItems = Menulink::getMenu('main');
		$listBuilder = new ListBuilder($mainMenuItems);
		$mainMenu = $listBuilder->buildPublic()->toHtml();

		// Footer menu
		$footerMenuItems = Menulink::getMenu('footer');
		$listBuilder = new ListBuilder($footerMenuItems);
		$footerMenu = $listBuilder->buildPublic($footerMenuItems)->toHtml();

		$instance = $this;
		View::composer($this->layout, function ($view) use ($instance) {
			$view->with('title', (implode(' ', $instance->title) . ' – ' . $instance->applicationName));
		});

		View::share('navBar', $navBar);
		View::share('mainMenu', $mainMenu);
		View::share('footerMenu', $footerMenu);
		View::share('languagesMenu', $menuBuilder->languagesMenu());
		View::share('lang', App::getLocale());

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