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
		foreach ($this->items as $item1) {
			$tmpArray[$item1->id] = $item1;
		}
		$this->items = $tmpArray;

		$deleteArray = array();
		// set children
		foreach ($this->items as $item2) {
			if ( $item2->parent && isset($this->items[$item2->parent]) ) {
				$this->items[$item2->parent]->children[] = $item2;
				$deleteArray[] = $item2->id;
			}
		}

		// delete moved items
		foreach ($deleteArray as $id) {
			unset($this->items[$id]);
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