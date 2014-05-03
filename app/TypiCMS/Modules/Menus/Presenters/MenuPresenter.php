<?php
namespace TypiCMS\Modules\Menus\Presenters;

use TypiCMS\Presenters\Presenter;

class MenuPresenter extends Presenter
{

    /**
    * Checkboxes
    *
    * @return string
    */
    public function checkbox()
    {
        // Disable checkbox when object has menulinks
        $disabled = $this->entity->menulinks->isEmpty() ? '' : ' disabled' ;

        return '<input type="checkbox" value="' . $this->entity->id . '"' . $disabled . '>';
    }
}
