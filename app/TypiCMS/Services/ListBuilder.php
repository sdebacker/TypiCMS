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


	public function toHtml($parameters = array())
	{
		$ulClass = isset($parameters['class']) ? $parameters['class'] : '' ;
		$ulId = isset($parameters['id']) ? $parameters['id'] : '' ;

		if (count($this->items)) {
			$this->list[] = ($this->list) ? '<ul class="dropdown-menu">' : '<ul id="'.$ulId.'" class="'.$ulClass.'" role="menu">' ;

			foreach ($this->items as $item) {

				// item
				$this->list[] = '<li class="'.$item->class.'" id="item_'.$item->id.'" role="menuitem">';
				$this->list[] = $item->anchor;

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