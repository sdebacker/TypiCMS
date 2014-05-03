<?php
namespace TypiCMS\Modules\Pages\Presenters;

use TypiCMS\Presenters\Presenter;

class PagePresenter extends Presenter
{
    public function publicUri($lang)
    {
        return '/' . $this->entity->$lang->uri;
    }
}
