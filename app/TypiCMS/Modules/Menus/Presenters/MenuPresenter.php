<?php
namespace TypiCMS\Modules\Menus\Presenters;

use TypiCMS\Presenters\AbstractPresenter;
use TypiCMS\Presenters\Presentable;

class MenuPresenter extends AbstractPresenter implements Presentable
{

    /**
    * Checkboxes
    *
    * @return string
    */
    public function checkbox()
    {
        // Disable checkbox when object has menulinks
        $disabled = $this->object->menulinks->isEmpty() ? '' : ' disabled' ;
        return '<input type="checkbox" value="' . $this->object->id . '"' . $disabled . '>';
    }

}
