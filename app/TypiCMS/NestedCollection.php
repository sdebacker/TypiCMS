<?php namespace TypiCMS;

use Illuminate\Database\Eloquent\Collection;

class NestedCollection extends Collection {

	private $total = 0;

	public function __construct(array $items = array())
	{
		parent::__construct($items);
		$this->total = count($items);
	}


	/**
	 * Nest items
	 *
	 * @param  array
	 * @return array
	 */
	public function nest()
	{
		// set keys to id
		$tmpArray = array();
		foreach ($this->items as $key => $item) {
			$tmpArray[$item->id] = $item;
		}
		$this->items = $tmpArray;

		// set children
		foreach ($this->items as $id => $item) {
			if ( $item->parent && isset($this->items[$item->parent]) ) {
				$this->items[$item->parent]->children[] = $item;
			}
		}

		// delete moved items
		foreach ($this->items as $id => $item) {
			if ($item->parent) {
				unset($this->items[$id]);
			}
		}
		return $this;
	}


	/**
	 * Get total items in collection
	 *
	 * @return int
	 */
	public function getTotal()
	{
		return $this->total;
	}

}