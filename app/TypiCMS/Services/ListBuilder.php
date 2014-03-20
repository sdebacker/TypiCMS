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

    /**
     * Build languages Menu.
     *
     * @return Collection
     */
    public function languagesMenuHtml($parameters)
    {
        return $this->languagesMenu($parameters, true);
    }

    /**
     * Build languages Menu.
     *
     * @return Collection
     */
    public function languagesMenu($parameters, $html = false)
    {
        $routeName = Route::current()->getName();

        if ( ! $routeName) {
            $slug = last(Request::segments());
            $id = Helpers::getIdFromSlug('pages', $slug);
        }

        $routeArray = explode('.', Route::current()->getName());

        $languagesMenu = array();

        if (count(Config::get('app.locales')) > 1) {

            foreach (Config::get('app.locales') as $lg) {

                $languagesMenu[] = (object) array(
                    'lang' => $lg,
                    'url' => '/' . $lg,
                    'class' => Config::get('app.locale') == $lg ? 'active' : ''
                );

            }

        }

        if ($html) {
            $class = isset($parameters['class']) ? $parameters['class'] : '' ;
            $id = isset($parameters['id']) ? $parameters['id'] : '' ;
            $html = '<ul class="' . $class . '" id="' . $id . '" role="menu">';
            foreach ($languagesMenu as $item):
                $html .= '<li class="' . $item->class . '" role="menuitem">';
                $html .= '<a href="' . $item->url . '">' . $item->lang . '</a>';
                $html .= '</li>';
            endforeach;
            $html .= '</ul>';

            return $html;
        }

        return $languagesMenu;

    }

}
