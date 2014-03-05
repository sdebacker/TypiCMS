<?php namespace TypiCMS\Services;

use DB;
use Route;
use Config;
use Request;

use TypiCMS\Services\Helpers;

class ListBuilder {

	private $list = array();
	protected $items = array();
	
	public function __construct($items = array())
	{
		$this->items = $items;
	}


	/**
	 * Build nested list for public side
	 *
	 * @param  array
	 * @return string
	 */
	public function buildPublic()
	{
		$this->items->each(function($menulink) {

			// Homepage
			if ($menulink->is_home) {
				$menulink->page_uri = Config::get('app.locale');
			}

			// Link tu URI (module for example)
			if ($menulink->uri) {
				$menulink->page_uri = $menulink->uri;
			}

			$menulink->page_uri = '/'.$menulink->page_uri;

			// Link to URL
			if ($menulink->url) {
				$menulink->page_uri = $menulink->url;
			}

			$activeUri = '/'.Request::path();

			if ( $menulink->page_uri == $activeUri or ( strlen($menulink->page_uri) > 3 and preg_match('@^'.$menulink->page_uri.'@', $activeUri) ) ) {
				// if item uri equals current uri
				// or current uri contain item uri (item uri must be bigger than 3 to avoid homepage link always active)
				// then add active class.
				$classArray = preg_split('/ /', $menulink->class, NULL, PREG_SPLIT_NO_EMPTY);
				$classArray[] = 'active';
				$menulink->class = implode(' ', $classArray);
			}
		});

		$this->items->nest();

		return $this;

	}

	public function toHtml($parameters = array())
	{
		$ulClass = isset($parameters['class']) ? $parameters['class'] : '' ;
		$ulId = isset($parameters['id']) ? $parameters['id'] : '' ;

		if (count($this->items)) {
			$this->list[] = ($this->list) ? '<ul class="dropdown-menu">' : '<ul id="'.$ulId.'" class="'.$ulClass.'" role="menu">' ;

			foreach ($this->items as $item) {

				$aClasses = array();
				$aDataToggle = '';
				if ($item->children) {
					$item->class .= ' dropdown';
					$aClasses[] = 'dropdown-toggle';
					$aDataToggle = 'data-toggle="dropdown" ';
				}

				// class
				$aClass = $aClasses ? 'class="'.implode(' ', $aClasses).'" ' : '' ;

				// target
				$aTarget = $item->target ? 'target="'.$item->target.'" ' : '' ;

				// item
				$this->list[] = '<li class="'.$item->class.'" id="item_'.$item->id.'" role="menuitem">';
				$this->list[] = '<a href="'.$item->page_uri.'" '.$aTarget.$aClass.$aDataToggle.'>';
				$this->list[] = $item->title;
				$this->list[] = ($item->children) ? '<span class="caret"></span>' : '' ;
				$this->list[] = '</a>';

				// sublists
				if ($item->children) {
					$this->items = $item->children;
					$this->toHtml();
				}

				$this->list[] = '</li>';
			}
			$this->list[] = '</ul>';
		}
		return implode("\r\n", $this->list);
	}


	public function sideList()
	{
		if (count($this->items)) {
			$this->list[] = '<ul class="menu-aside" role="menu">';

			foreach ($this->items as $item) {

				$liClass = Request::is($item->uri) ? ' class="active"' : '' ;
				$this->list[] = '<li'.$liClass.' role="menuitem">';
				$this->list[] = '<a href="/'.$item->uri.'">';
				$this->list[] = $item->title;
				$this->list[] = '</a>';

				// sublists
				if (count($item->children)) {
					$this->items = $item->children;
					$this->sideList();
				}

				$this->list[] = '</li>';
			}
			$this->list[] = '</ul>';
		}
		return implode("\r\n", $this->list);
	}


	/**
	 * Build languages Menu.
	 *
	 * @return Collection
	 */
	public function languagesMenuHtml($parameters)
	{
		return $this->languagesMenu($parameters, true);
	}


	/**
	 * Build languages Menu.
	 *
	 * @return Collection
	 */
	public function languagesMenu($parameters, $html = false)
	{

		$routeArray = explode('.', Route::current()->getName());

		$module = isset($routeArray[1]) ? $routeArray[1] : 'pages' ;
		$segments = Request::segments();

		if (end($routeArray) == 'slug') {
			// Last segment is a slug
			$slug = end($segments);
			$id = Helpers::getIdFromSlug($module, $slug);
			$slugs = Helpers::getSlugsFromId($module, $id);
		}

		if (isset($routeArray[2]) and $routeArray[2] == 'categories') {
			// There is a category
			if (end($routeArray) != 'categories') {
				array_pop($segments); 
			}
			$category = end($segments);

			$id = Helpers::getIdFromSlug('categories', $category);
			$categories = DB::table($module)
				->join('categories', 'projects.category_id', '=', 'categories.id')
				->join('category_translations', 'category_translations.category_id', '=', 'categories.id')
				->where('categories.id', $id)
				->where('category_translations.status', 1)
				->lists('slug', 'locale');
		}

		$languagesMenu = array();

		if (count(Config::get('app.locales')) > 1) {

			foreach (Config::get('app.locales') as $lg) {

				// Build translated routes
				$translatedRouteArray = $routeArray;
				$translatedRouteArray[0] = $lg;

				$translatedRouteName = implode('.', $translatedRouteArray);
				$routeParams = array();

				if (in_array('categories', $translatedRouteArray)) {
					if (isset($categories[$lg])) {
						$routeParams[] = $categories[$lg];
					} else {
						array_pop($translatedRouteArray);
					}
				}
				if (in_array('slug', $translatedRouteArray)) {
					if (isset($slugs[$lg])) {
						$routeParams[] = $slugs[$lg];
					} else {
						array_pop($translatedRouteArray);
					}
				}
				$translatedRouteName = implode('.', $translatedRouteArray);

				// single page or module index
				$route = Route::getRoutes()->hasNamedRoute($translatedRouteName);
				// if route in this lang doesn't exist, redirect to homepage
				! $route and $translatedRouteName = $lg;

				$languagesMenu[] = (object) array(
					'lang' => $lg,
					'url' => route($translatedRouteName, $routeParams),
					'class' => Config::get('app.locale') == $lg ? 'active' : ''
				);

			}

		}

		if ($html) {
			$class = isset($parameters['class']) ? $parameters['class'] : '' ;
			$id = isset($parameters['id']) ? $parameters['id'] : '' ;
			$html = '<ul class="' . $class . '" id="' . $id . '" role="menu">';
			foreach ($languagesMenu as $item):
				$html .= '<li class="' . $item->class . '" role="menuitem">';
				$html .= '<a href="' . $item->url . '">' . $item->lang . '</a>';
				$html .= '</li>';
			endforeach;
			$html .= '</ul>';
			return $html;
		}

		return $languagesMenu;

	}


}