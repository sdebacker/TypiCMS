<?php namespace App\Controllers;

use Controller;
use View;
use Config;
use App;
use Request;

use TypiCMS\Models\Menulink;
use TypiCMS\Services\MenuBuilder;
use TypiCMS\Services\ListBuilder\ListBuilder;
use Illuminate\Support\Collection;

abstract class BaseController extends Controller {

	/**
	 * The layout that should be used for responses.
	 */
	protected $layout = 'public/master';

	/**
	 * Menus.
	 */
	protected $navBar;
	protected $menuBuilder;
	protected $mainMenu;
	protected $footerMenu;

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
		// top bar
		$this->navBar = View::make('_navbar')->render();

		// set locale if in URL
		$firstSegment = Request::segment(1);
		if (in_array($firstSegment, Config::get('app.locales'))) {
			App::setLocale($firstSegment);
		}

		$this->repository = $repository;
		$this->menuBuilder = new MenuBuilder;
		$this->applicationName = Config::get('settings.website_title');

		// Main menu
		$mainMenuItems = Menulink::getMenu('main');
		$listBuilder = new ListBuilder;
		$this->mainMenu = $listBuilder->buildPublic($mainMenuItems);

		// Footer menu
		$footerMenuItems = Menulink::getMenu('footer');
		$listBuilder = new ListBuilder;
		$this->footerMenu = $listBuilder->buildPublic($footerMenuItems);

		$instance = $this;
		View::composer($this->layout, function ($view) use ($instance) {
			$view->with('title', (implode(' ', $instance->title) . ' – ' . $instance->applicationName));
			$view->with('navBar', $this->navBar);
		});

		View::share('mainMenu', $this->mainMenu);
		View::share('footerMenu', $this->footerMenu);
		View::share('languagesMenu', $this->menuBuilder->languagesMenu());
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