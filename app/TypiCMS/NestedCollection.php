<?php namespace TypiCMS;

use Illuminate\Database\Eloquent\Collection;
use TypiCMS\Services\ListBuilder\ListBuilder;

class NestedCollection extends Collection {

	private $total = 0;
	protected $list;

	public function __construct(array $items = array())
	{
		parent::__construct($items);
		$this->total = count($items);
	}


	/**
	 * Nest items
	 *
	 * @return NestedCollection
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
	 * Build html list
	 *
	 * @param array
     * @return string
	 */
	public function buildList($properties = array())
	{
		$this->list = with(new ListBuilder(null, $properties))->build($this->items);
		return $this;
	}


	public function getList()
	{
		return $this->list;
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