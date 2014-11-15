<?php
namespace TypiCMS\Modules\Blocks\Presenters;

use TypiCMS\Presenters\Presenter;

class BlockPresenter extends Presenter
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
