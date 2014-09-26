<?php
namespace TypiCMS\Modules\Blocks\Presenters;

use TypiCMS\Presenters\Presenter;

class BlockPresenter extends Presenter
{

    /**
     * Return filename
     * @return String
     */
    public function title()
    {
        return $this->entity->name;
    }
}
