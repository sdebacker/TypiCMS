<?php
namespace TypiCMS\Modules\Categories\Presenters;

use TypiCMS\Presenters\AbstractPresenter;
use TypiCMS\Presenters\Presentable;

class CategoryPresenter extends AbstractPresenter implements Presentable
{

    /**
    * Checkboxes
    *
    * @return string
    */
    public function checkbox()
    {
        // Disable checkbox when category has projects
        $disabled = $this->object->projects->isEmpty() ? '' : ' disabled' ;

        return '<input type="checkbox" value="' . $this->object->id . '"' . $disabled . '>';
    }
}
