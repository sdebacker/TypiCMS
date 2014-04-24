<?php
namespace TypiCMS\Services;

use DB;
use Route;
use Config;
use Request;

class ListBuilder
{
    private $list = array();
    protected $items = array();

    public function __construct($items = array())
    {
        $this->items = $items;
    }

    public function sideList()
    {
        if (count($this->items)) {
            $this->list[] = '<ul class="menu-aside" role="menu">';

            foreach ($this->items as $item) {

                $liClass = Request::is($item->uri) ? ' class="active"' : '' ;
                $this->list[] = '<li'.$liClass.' role="menuitem">';
                $this->list[] = '<a href="/'.$item->uri.'">';
                $this->list[] = $item->title;
                $this->list[] = '</a>';

                // sublists
                if (count($item->children)) {
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
