<?php namespace TypiCMS\Services\ListBuilder;

use Illuminate\Database\Eloquent\Collection;
use Config;
use Request;
use Route;
use DB;

use TypiCMS\Services\Helpers;

class ListBuilder {

	private $list = array();
	public $items = array();
	
	private $id = 'listMain';
	private $class = array('list-main');
	private $nested = false;
	private $sortable = false;
	private $gallery = false;
	private $checkboxes = true;
	private $display = array('%s', 'title');
	private $bootstrap = false;
	private $public = false;
	private $switch = true;
	private $defaultChild = false;
	private $langSignal = false;
	private $member_access = false;
	private $formatForDisplay;
	private $fieldsForDisplay;

	public function __construct($items = array(), array $properties = array())
	{
		$this->items = $items;
		foreach ($properties as $property => $value) {
			$this->$property = $value;
		}
		$this->nested and $this->class[] = 'nested';
		$this->sortable and $this->class[] = 'sortable';
		// Fields to display
		$this->formatForDisplay = array_shift($this->display);
		$this->fieldsForDisplay = $this->display;
	}

	/**
	 * Nest items
	 *
	 * @param  array
	 * @return string
	 */
	public function build(array $items = array())
	{
		if (count($items)) {
			$this->list[] = ($this->list) ? '<ul role="menu">' : '<ul id="'.$this->id.'" class="'.implode(' ', $this->class).'" role="menu">' ;

			foreach ($items as $item) {
				$liClass = array();
				// online / offline class
				$liClass[] = $item->status ? 'online' : 'offline' ;
				// item
				$this->list[] = '<li id="item_'.$item->id.'" class="'.implode(' ', $liClass).'" role="menuitem">';
				$this->list[] = '<div>';
				$this->checkboxes and $this->list[] = '<input type="checkbox" value="'.$item->id.'">';
				$this->switch and $this->list[] = '<span class="switch">'.trans('global.En ligne/Hors ligne').'</span>';

				// Anchor
				$this->getAnchor($item);

				// Attachments
				$this->getAttachmentsBtn($item);

				$this->list[] = '</div>';
				// sublists
				$item->children and $this->build($item->children);
				$this->list[] = '</li>';
			}
			$this->list[] = '</ul>';
		}
		return implode("\r\n", $this->list);
	}

	/**
	 * Attachments indications
	 *
	 * @param  $item
	 * @return $this
	 */
	public function getAttachmentsBtn($item)
	{
		if ($item->files) {
			$this->list[] = '<div class="attachments">';
			$nb = count($item->files);
			$attachmentClass = $nb ? '' : 'text-muted' ;
			$this->list[] = '<a class="'.$attachmentClass.'" href="'.route('admin.'.$item->route.'.files.index', $item->id).'">'.$nb.' '.trans_choice('global.modules.files', $nb).'</a>';
			$this->list[] = '</div>';
		}
		return $this;
	}

	/**
	 * Main anchor
	 *
	 * @param  $item
	 * @return $this
	 */
	public function getAnchor($item)
	{
		$params = $item->id;
		// Pas propre :
		if (isset($item->menu_id) and $item->menu_id) {
			$params = array($item->menu_id, $item->id);
		}

		$this->list[] = '<a href="'.route('admin.'.$item->route.'.edit', $params).'">';

		$fieldsToDisplay = array();
		foreach ($this->fieldsForDisplay as $fieldForDisplay) {
			if (method_exists($item, $fieldForDisplay)) {
				$fieldsToDisplay[] = $item->$fieldForDisplay();
			} else if (is_object($item->$fieldForDisplay) and get_class($item->$fieldForDisplay) == 'Carbon\Carbon') {
				$fieldsToDisplay[] = $item->$fieldForDisplay->format('d.m.Y');
			} else {
				$fieldsToDisplay[] = $item->$fieldForDisplay;
			}
		}
		$this->list[] = vsprintf($this->formatForDisplay, $fieldsToDisplay);

		$this->list[] = '</a>';

		return $this;
	}

	/**
	 * Nest items
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

		if (count($this->items)) {
			$this->list[] = ($this->list) ? '<ul class="dropdown-menu">' : '<ul id="'.$this->id.'" class="'.$ulClass.'" role="menu">' ;

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
				$this->list[] = '<li id="item_'.$item->id.'" class="'.$item->class.'" role="menuitem">';

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
	public function languagesMenu()
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
				->join('categories_translations', 'categories_translations.category_id', '=', 'categories.id')
				->where('categories.id', $id)
				->where('categories_translations.status', 1)
				->lists('slug', 'lang');
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

		return $languagesMenu;

	}


}