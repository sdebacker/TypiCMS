<?php
namespace TypiCMS\Modules\Groups\Presenters;

use TypiCMS\Presenters\Presenter;

class ModulePresenter extends Presenter
{

    /**
    * Checkboxes
    *
    * @return string
    */
    public function checkbox()
    {
        // Disable checkbox when object has menulinks
        $disabled = $this->entity->id == 1 ? ' disabled' : '' ;

        return '<input type="checkbox" value="' . $this->entity->id . '"' . $disabled . '>';
    }

    /**
     * Return name
     * @return String
     */
    public function title()
    {
        return $this->entity->name;
    }
}
