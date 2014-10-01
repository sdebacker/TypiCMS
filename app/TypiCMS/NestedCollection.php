<?php
namespace TypiCMS;

use App;
use Illuminate\Database\Eloquent\Collection;

class NestedCollection extends Collection
{
    private $total = 0;

    public function __construct(array $items = array())
    {
        parent::__construct($items);
        $this->each(function ($item) {
            $item->models = App::make('\Illuminate\Support\Collection');
        });
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
        $this->items = $this->getDictionary();

        // Set children
        $keysToDelete = array();
        foreach ($this->items as $item) {
            if ($item->parent && isset($this->items[$item->parent])) {
                $this->items[$item->parent]->models->push($item);
                $keysToDelete[] = $item->id;
            }
        }

        // Delete moved items
        $this->items = array_values(array_except($this->items, $keysToDelete));

        return $this;
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
