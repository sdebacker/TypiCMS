<?php
namespace TypiCMS\Modules\Tags\Presenters;

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
        return $this->entity->tag;
    }
}
