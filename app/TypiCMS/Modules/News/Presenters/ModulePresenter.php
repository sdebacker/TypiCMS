<?php
namespace TypiCMS\Modules\News\Presenters;

use TypiCMS\Presenters\Presenter;

class ModulePresenter extends Presenter
{

    public function dateLocalized()
    {
        return $this->entity->date->formatLocalized('%d %B %Y %H:%M');
    }
}
