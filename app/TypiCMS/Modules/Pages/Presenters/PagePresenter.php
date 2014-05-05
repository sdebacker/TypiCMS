<?php
namespace TypiCMS\Modules\Pages\Presenters;

use TypiCMS\Presenters\Presenter;

class PagePresenter extends Presenter
{
    /**
     * Get public url
     * @param  string $lang
     * @return string       uri
     */
    public function publicUri($lang)
    {
        return '/' . $this->entity->$lang->uri;
    }
}
