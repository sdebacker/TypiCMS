<?php
namespace TypiCMS\Modules\Groups\Presenters;

use TypiCMS\Presenters\AbstractPresenter;
use TypiCMS\Presenters\Presentable;

class GroupPresenter extends AbstractPresenter implements Presentable
{

    /**
    * Checkboxes
    *
    * @return string
    */
    public function checkbox()
    {
        // Disable checkbox when object has menulinks
        $disabled = $this->object->id == 1 ? ' disabled' : '' ;

        return '<input type="checkbox" value="' . $this->object->id . '"' . $disabled . '>';
    }
}
