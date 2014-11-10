<?php
namespace TypiCMS\Modules\Places\Presenters;

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
        return $this->entity->title;
    }
}
