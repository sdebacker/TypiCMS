<?php
namespace TypiCMS;

use App;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Collection as BaseCollection;

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
     * Recursive function that flatten a nested Collection
     * with characters (default is four spaces)
     * 
     * @param  BaseCollection|null $collection
     * @param  integer             $level
     * @param  array               &$flattened
     * @param  string              $key
     * @param  string              $indentChars
     * @return array
     */
    public function listsFlattened(BaseCollection $collection = null, $level = 0, array &$flattened = [], $key = 'title', $indentChars = '&nbsp;&nbsp;&nbsp;&nbsp;')
    {
        $collection = $collection ? : $this ;
        foreach ($collection as $item) {
            $flattened[str_repeat($indentChars, $level) . $item->$key] = $item->id;
            if ($item->items) {
                $this->listsFlattened($item->items, $level + 1, $flattened);
            }
        }

        return $flattened;
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
