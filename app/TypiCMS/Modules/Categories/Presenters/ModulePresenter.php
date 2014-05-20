<?php
namespace TypiCMS\Modules\Categories\Presenters;

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
        // Disable checkbox when category has projects
        $disabled = $this->entity->projects->isEmpty() ? '' : ' disabled' ;

        return '<input type="checkbox" value="' . $this->entity->id . '"' . $disabled . '>';
    }
}
