<?php
namespace TypiCMS\Modules\News\Presenters;

use TypiCMS\Presenters\Presenter;

class NewsPresenter extends Presenter
{

    public function dateLocalized()
    {
        return $this->entity->date->formatLocalized('%d %B %Y %H:%M');
    }
}
