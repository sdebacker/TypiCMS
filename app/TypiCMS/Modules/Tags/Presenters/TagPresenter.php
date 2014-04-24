<?php
namespace TypiCMS\Modules\Tags\Presenters;

use TypiCMS\Presenters\AbstractPresenter;
use TypiCMS\Presenters\Presentable;

class TagPresenter extends AbstractPresenter implements Presentable
{

    /**
    * Checkboxes
    *
    * @return string
    */
    public function checkbox()
    {
        // Disable checkbox when object has menulinks
        $disabled = $this->object->uses ? ' disabled' : '' ;
        return '<input type="checkbox" value="' . $this->object->id . '"' . $disabled . '>';
    }
}
