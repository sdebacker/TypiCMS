<?php
namespace TypiCMS\Modules\Menus\Presenters;

use TypiCMS\Presenters\Presenter;

class ModulePresenter extends Presenter
{

    /**
     * Get title
     * 
     * @return string
     */
    public function title()
    {
        return $this->entity->name;
    }
}
