<?php
namespace TypiCMS\Modules\Groups\Presenters;

use TypiCMS\Presenters\Presenter;

class ModulePresenter extends Presenter
{

    /**
     * Return name
     * @return String
     */
    public function title()
    {
        return $this->entity->name;
    }
}
