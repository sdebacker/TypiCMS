<?php namespace TypiCMS\Services\ListBuilder;

use Illuminate\Database\Eloquent\Collection;
use Config;
use Request;

class ListBuilder {

	private $list = array();
	public $items = array();
	
	private $id = 'listMain';
	private $class = array('list-main');
	private $nested = false;
	private $sortable = false;
	private $gallery = false;
	private $checkboxes = true;
	private $nbImages = false;
	private $display = array('%s', 'title');
	private $bootstrap = false;
	private $public = false;
	private $switch = true;
	private $defaultChild = false;
	private $langSignal = false;
	private $member_access = false;
	private $formatForDisplay;
	private $fieldsForDisplay;
	
	public function __construct($items, array $properties = array())
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
		if ($items) {
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

				$params = $item->id;
				// Pas propre :
				if (isset($item->menu_id) and $item->menu_id) {
					$params = array($item->menu_id, $item->id);
				}
				// Pas propre :
				// if (isset($item->category_id) and $item->category_id) {
				// 	$params = array($item->category_id, $item->id);
				// }

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
				// if item uri equals current uri OR
				// current uri contain item uri (item uri must be bigger than 3 to avoid homepage link always active)
				// Add active class.
				$classArray = preg_split('/ /', $menulink->class, NULL, PREG_SPLIT_NO_EMPTY);
				$classArray[] = 'active';
				$menulink->class = implode(' ', $classArray);
			}
		});

		$this->items->nest();

		return $this;

	}

	public function toHtml()
	{
		if (count($this->items)) {
			$this->list[] = ($this->list) ? '<ul class="dropdown-menu" role="menu">' : '<ul id="'.$this->id.'" class="nav nav-pills" role="menu">' ;

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
			$this->list[] = '<ul class="list-group" role="menu">';

			foreach ($this->items as $item) {

				$liClass = array('list-group-item');

				if (Request::path() == $item->uri) {
					$liClass[] = 'active';
				}

				$this->list[] = '<li class="'.implode(' ', $liClass).'" role="menuitem">';
				$this->list[] = '<a href="/'.$item->uri.'">';
				$this->list[] = $item->title;
				$this->list[] = '</a>';

				// sublists
				if ($item->children) {
					$this->items = $item->children;
					$this->sideList();
				}

				$this->list[] = '</li>';
			}
			$this->list[] = '</ul>';
		}
		return implode("\r\n", $this->list);
	}

}