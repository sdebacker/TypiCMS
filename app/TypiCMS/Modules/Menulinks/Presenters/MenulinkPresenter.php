<?php
namespace TypiCMS\Modules\Menulinks\Presenters;

use TypiCMS\Presenters\AbstractPresenter;
use TypiCMS\Presenters\Presentable;

class MenulinkPresenter extends AbstractPresenter implements Presentable
{

    public function menuclass()
    {
        return $this->object->menuclass;
    }

    /**
    * Edit button
    *
    * @return string
    */
    public function edit()
    {
        return '<a class="btn btn-default btn-xs" href="' . route('admin.menus.menulinks.edit', array($this->object->menu_id, $this->object->id)) . '">' . trans('global.Edit') . '</a>';
    }

    public function anchor()
    {
        $aClasses = array();
        $anchor = array();
        $aDataToggle = '';

        if ($this->object->children) {
            $this->object->class .= ' dropdown';
            $aClasses[] = 'dropdown-toggle';
            $aDataToggle = 'data-toggle="dropdown" ';
        }

        // class
        $aClass = $aClasses ? 'class="'.implode(' ', $aClasses).'" ' : '' ;

        // target
        $aTarget = $this->object->target ? 'target="'.$this->object->target.'" ' : '' ;

        $anchor[] = '<a href="'.$this->object->page_uri.'" '.$aTarget.$aClass.$aDataToggle.'>';
        $anchor[] = $this->object->title;
        $anchor[] = ($this->object->children) ? '<span class="caret"></span>' : '' ;
        $anchor[] = '</a>';

        return implode($anchor);
    }

}
