<?php namespace TypiCMS\Services\TableBuilder;

use Config;
use Request;
use Route;
use DB;

use TypiCMS\Services\Helpers;

class TableBuilder {

	private $table = array();
	public $items = array();
	
	private $id = 'table-main';
	private $class = array('table', 'table-main');
	private $checkboxes = true;
	private $switch = true;
	private $files = true;
	private $display = array(array('%s', 'title'));
	private $fieldsForDisplay;

	public function __construct($items = array(), array $properties = array())
	{
		$this->items = $items;
		foreach ($properties as $property => $value) {
			$this->$property = $value;
		}
		// Fields to display
		$this->fieldsForDisplay = $this->display;
	}

	/**
	 * Nest items
	 *
	 * @param  array
	 * @return string
	 */
	public function build($items)
	{
		if (count($items)) {
			$this->table[] = '<table id="'.$this->id.'" class="'.implode(' ', $this->class).'">' ;

			$this->getThead();

			$this->table[] = '<tbody>';

			foreach ($items as $item) {

				$trClass = array();

				// Online / Offline class
				$trClass[] = $item->status ? 'online' : 'offline' ;
				
				// Item
				$this->table[] = '<tr id="item_'.$item->id.'" class="'.implode(' ', $trClass).'" role="menuitem">';
				$this->checkboxes and $this->table[] = '<td><input type="checkbox" value="'.$item->id.'"></td>';

				$this->table[] = $this->getAnchor($item);

				$this->switch and $this->table[] = '<td><span class="switch">'.trans('global.En ligne/Hors ligne').'</span></td>';

				foreach ($this->fieldsForDisplay as $fieldForDisplay) {
					$this->getFields($item, $fieldForDisplay);
				}

				// Attachments
				$this->getAttachmentsBtn($item);

				$this->table[] = '</tr>';

			}

			$this->table[] = '</tbody>';

			$this->table[] = '</table>';

		}
		return implode("\r\n", $this->table);
	}


	/**
	 * THEAD
	 *
	 * @param  $item
	 * @return $this
	 */
	public function getThead()
	{
		$this->table[] = '<thead>';
		$this->checkboxes and $this->table[] = '<th></th>';
		$this->checkboxes and $this->table[] = '<th></th>';
		$this->switch and $this->table[] = '<th>' . trans('validation.attributes.online') . '</th>';
		foreach ($this->fieldsForDisplay as $fieldForDisplay) {
			$this->table[] = '<th>' . trans('validation.attributes.' . end($fieldForDisplay)) . '</th>';
		}
		$this->files and $this->table[] = '<th>' . trans('validation.attributes.files') . '</th>';
		$this->table[] = '</thead>';
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
			$this->table[] = '<td class="attachments">';
			$nb = count($item->files);
			$attachmentClass = $nb ? '' : 'text-muted' ;
			$this->table[] = '<a class="'.$attachmentClass.'" href="'.route('admin.'.$item->route.'.files.index', $item->id).'">'.$nb.' '.trans_choice('modules.files.files', $nb).'</a>';
			$this->table[] = '</td>';
		}
	}


	/**
	 * Edit anchor
	 *
	 * @param  $item
	 * @return HTML string
	 */
	public function getAnchor($item)
	{

		$params = $item->id;
		$route = $item->getTable();
		// Pas propre :
		if (isset($item->menu_id) and $item->menu_id) {
			$params = array($item->menu_id, $item->id);
			$route = 'menus.menulinks';
		}

		return '<td><a class="btn btn-default btn-xs" href="'.route('admin.'.$route.'.edit', $params).'">Modifier</a></td>';

	}


	/**
	 * Fields value
	 *
	 * @param  $item
	 * @return $this
	 */
	public function getFields($item, $fieldsForDisplay)
	{
		$formatForDisplay = array_shift($fieldsForDisplay);

		$fieldsToDisplay = array();
		foreach ($fieldsForDisplay as $fieldForDisplay) {
			if (method_exists($item, $fieldForDisplay)) {
				$fieldsToDisplay[] = $item->$fieldForDisplay();
			} else if (is_object($item->$fieldForDisplay) and get_class($item->$fieldForDisplay) == 'Carbon\Carbon') {
				$fieldsToDisplay[] = $item->$fieldForDisplay->format('d.m.Y');
			} else if (is_array($item->$fieldForDisplay)) {
				$fieldsToDisplay[] = implode(', ', $item->$fieldForDisplay);
			} else {
				$fieldsToDisplay[] = $item->$fieldForDisplay;
			}
		}

		$this->table[] = '<td>' . vsprintf($formatForDisplay, $fieldsToDisplay) . '</td>';

		return $this;
	}

}