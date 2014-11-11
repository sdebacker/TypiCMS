<?php
namespace TypiCMS;

use App;
use Illuminate\Database\Eloquent\Collection;

class NestableCollection extends Collection
{
    private $total = 0;
    private $parentKey = null;

    public function __construct(array $items = array(), $parentKey = 'parent_id')
    {
        parent::__construct($items);
        $this->total = count($items);
        $this->parentKey = $parentKey;
    }

    /**
     * Nest items
     *
     * @return mixed boolean|NestableCollection
     */
    public function nest()
    {
        $parentKey = $this->parentKey;
        if (! $parentKey) {
            return $this;
        }

        // Set id as keys
        $this->items = $this->getDictionary();

        $keysToDelete = array();

        // add empty children collection.
        $this->each(function ($item) {
            if (! $item->items) {
                $item->items = App::make('Illuminate\Support\Collection');
            }
        });

        // add items to children collection
        foreach ($this->items as $key => $item) {
            if ($item->$parentKey && isset($this->items[$item->$parentKey])) {
                $this->items[$item->$parentKey]->items->push($item);
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
