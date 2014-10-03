<?php
namespace TypiCMS\Modules\Menulinks\Presenters;

use TypiCMS\Presenters\Presenter;

class ModulePresenter extends Presenter
{

    public function menuclass()
    {
        return $this->entity->menuclass;
    }
}
