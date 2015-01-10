<?php
namespace TypiCMS\Services;

use Illuminate\Support\Collection;

class Indent
{
    private $items = [];
    private $indentChars = '&nbsp;&nbsp;&nbsp;&nbsp;';

    /**
     * Flatten and indent a nested Collection
     * 
     * @param  Collection $collection
     * @return array
     */
    public static function collection(Collection $collection)
    {
        $instance = new self();
        return $instance->indent($collection);
    }

    /**
     * Recursive method
     *
     * @return Collection
     */
    public function indent(Collection $collection, $level = 0)
    {
        foreach ($collection as $item) {
            $this->items[str_repeat($this->indentChars, $level) . $item->title] = $item->id;
            if ($item->items) {
                $this->indent($item->items, $level + 1);
            }
        }

        return $this->items;
    }
}
