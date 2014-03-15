<?php namespace TypiCMS;

use Illuminate\Database\Eloquent\Collection;

class NestedCollection extends Collection {

    private $total = 0;
    protected $class;

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
        // Set id as keys
        $this->items = $this->getDictionary($this);

        // Set children
        $deleteArray = array();
        foreach ($this->items as $item) {
            if ( $item->parent && isset($this->items[$item->parent]) ) {
                if ( ! $this->items[$item->parent]->children) {
                    $this->items[$item->parent]->children = new \Illuminate\Support\Collection;
                }
                $this->items[$item->parent]->children->put($item->id, $item);
                $deleteArray[] = $item->id;
            }
        }

        // Delete moved items
        $this->items = array_except($this->items, $deleteArray);

        return $this;
    }

    public function setClass($class = '')
    {
        $this->class = $class;
    }

    public function getClass()
    {
        return $this->class;
    }

    /**
     * Get total items in nested collection
     *
     * @return int
     */
    public function getTotal()
    {
        return $this->total;
    }

}