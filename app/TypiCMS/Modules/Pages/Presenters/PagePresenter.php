<?php
namespace TypiCMS\Modules\Pages\Presenters;

use TypiCMS\Presenters\Presentable;
use TypiCMS\Presenters\AbstractPresenter;

class PagePresenter extends AbstractPresenter implements Presentable
{
    public function publicUri($lang)
    {
        return '/' . $this->object->$lang->uri;
    }
}
